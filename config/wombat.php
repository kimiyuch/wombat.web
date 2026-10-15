<?php

return [
    // GitHub repository of the macOS app; releases are published there.
    'repository_url' => env('WOMBAT_REPOSITORY_URL', 'https://github.com/kimiyuch/wombat.app'),

    // Always points at the DMG of the latest release.
    'download_url' => env('WOMBAT_DOWNLOAD_URL', 'https://github.com/kimiyuch/wombat.app/releases/latest/download/Wombat.dmg'),

    // The app's CHANGELOG.md, attached to every release; the changelog page is built from it.
    'changelog_url' => env('WOMBAT_CHANGELOG_URL', 'https://github.com/kimiyuch/wombat.app/releases/latest/download/CHANGELOG.md'),
];
