<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ChangelogPageTest extends TestCase
{
    private const CHANGELOG = <<<'MD'
        # Changelog

        ## 0.2 (2026-10-09)

        - **Built-in video player.** Play finished downloads from the inspector, or open any
          video with File → Open Video….
        - Works with the **media keys**.

        ## 0.1 (2026-10-08)

        - First release.
        MD;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
    }

    public function test_changelog_page_lists_releases_from_the_app_changelog(): void
    {
        Http::fake([config('wombat.changelog_url') => Http::response(self::CHANGELOG)]);

        $this->get('/changelog')
            ->assertOk()
            ->assertSee('What’s new in Wombat')
            ->assertSeeInOrder(['0.2', 'October 9, 2026', 'Built-in video player', 'Play finished downloads from the inspector, or open any video with File → Open Video….'])
            ->assertSee('Works with the <strong>media keys</strong>.', escape: false)
            ->assertSeeInOrder(['0.1', 'October 8, 2026', 'First release.']);
    }

    public function test_changelog_is_cached_between_requests(): void
    {
        Http::fake([config('wombat.changelog_url') => Http::response(self::CHANGELOG)]);

        $this->get('/changelog')->assertOk();
        $this->get('/changelog')->assertOk()->assertSee('Built-in video player');

        Http::assertSentCount(1);
    }

    public function test_last_copy_is_shown_when_github_is_unreachable(): void
    {
        Storage::disk('local')->put('changelog.md', self::CHANGELOG);
        touch(Storage::disk('local')->path('changelog.md'), time() - 7200);
        Http::fake([config('wombat.changelog_url') => Http::response('', 503)]);

        $this->get('/changelog')->assertOk()->assertSee('Built-in video player');
    }

    public function test_empty_changelog_says_the_first_release_is_coming(): void
    {
        Http::fake([config('wombat.changelog_url') => Http::response('', 404)]);

        $this->get('/changelog')->assertOk()->assertSee('first release is still in its burrow');
    }

    public function test_home_page_links_to_changelog(): void
    {
        $this->get('/')->assertOk()->assertSee('href="/changelog"', escape: false);
    }
}
