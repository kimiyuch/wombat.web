# wombat.web

The website for Wombat, a small disk space app for macOS. Live at [wombat.kimiyu.ch](https://wombat.kimiyu.ch).

A single-page Laravel 13 site styled with Tailwind CSS 4, built like [joey.web](https://github.com/kimiyuch/joey.web).

## Local development

The site runs in [Herd](https://herd.laravel.com) at `https://wombat.web.test`.

```sh
composer install
npm install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite && php artisan migrate
npm run dev       # or: npm run build
```

## Deploying

```sh
npm run build     # if you changed the design; commit public/build
./deploy.sh
```

`deploy.sh` runs the tests, exports the committed code, installs production dependencies and syncs it to Hostpoint over SSH with your own key. The server's `.env`, `public/.htaccess` (the PHP version is set there through the Hostpoint panel) and `storage/` are left alone. GitHub Actions only runs the tests.

## Where things are

| | |
|---|---|
| `resources/views/home.blade.php` | The landing page |
| `resources/views/components/app-window.blade.php` | The Wombat window mock in the hero |
| `resources/views/components/layouts/app.blade.php` | The HTML shell, fonts and meta tags |
| `resources/css/app.css` | Theme colors (`burrow` for the icon's dusky indigo, `area-*` for the usage bar) and fonts |
| `config/wombat.php` | Repository and download links |
| `public/images/wombat.png` | The app icon, rendered by `scripts/make-icon.mjs` in the app's repository |

Downloads always point at the latest GitHub release (`releases/latest/download/Wombat.dmg`), and the changelog page reads the `CHANGELOG.md` attached to that release (fetched at most every five minutes, see `app/Changelog.php`), so publishing a new version of the app doesn't require a change here.
