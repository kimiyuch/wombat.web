<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * The releases in the app's CHANGELOG.md, as attached to its latest GitHub release,
 * so a new version shows up here as soon as it's published.
 */
class Changelog
{
    private const FILE = 'changelog.md';

    // Short, so a release shows up within minutes; it's still one small request every few minutes at most.
    private const MAX_AGE = 300;

    /**
     * @return list<array{version: string, date: string, title: ?string, changes: list<string>}>
     */
    public static function releases(): array
    {
        return self::parse(self::markdown());
    }

    /**
     * Parses "## 0.2 (2026-10-09)" sections of bullets. A bold first sentence ("- **Video player.** …")
     * becomes the release's title. Changes are returned as HTML.
     */
    public static function parse(string $markdown): array
    {
        $releases = [];

        foreach (preg_split('/^## /m', $markdown) as $section) {
            if (! preg_match('/\A(\S+) \((\d{4}-\d{2}-\d{2})\)\n(.*)\z/s', $section, $match)) {
                continue;
            }

            // Wrapped lines of a bullet are indented; join them back up.
            $body = preg_replace('/\n[ \t]+/', ' ', trim($match[3]));
            $changes = array_map('trim', preg_split('/^- /m', $body, -1, PREG_SPLIT_NO_EMPTY));

            $title = null;
            if ($changes && preg_match('/\A\*\*(.+?)\.\*\*\s*(.*)\z/s', $changes[0], $lead)) {
                $title = $lead[1];
                $changes[0] = $lead[2];
            }

            $releases[] = [
                'version' => $match[1],
                'date' => $match[2],
                'title' => $title,
                'changes' => array_values(array_map(
                    fn (string $change) => trim(Str::inlineMarkdown($change, ['html_input' => 'escape', 'allow_unsafe_links' => false])),
                    array_filter($changes, fn (string $change) => $change !== ''),
                )),
            ];
        }

        return $releases;
    }

    /**
     * Fetched at most every five minutes. If GitHub can't be reached, the last copy is kept for another five.
     */
    private static function markdown(): string
    {
        $disk = Storage::disk('local');
        $cached = $disk->exists(self::FILE) ? $disk->get(self::FILE) : null;

        if ($cached !== null && time() - $disk->lastModified(self::FILE) < self::MAX_AGE) {
            return $cached;
        }

        try {
            $response = Http::timeout(5)->get(config('wombat.changelog_url'));
            if ($response->successful() && str_contains($response->body(), '## ')) {
                $disk->put(self::FILE, $response->body());

                return $response->body();
            }
        } catch (Throwable) {
            // Fall through to the last copy.
        }

        if ($cached !== null) {
            touch($disk->path(self::FILE));
        }

        return $cached ?? '';
    }
}
