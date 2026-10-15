@php
    // A made-up 1 TB Mac. The slices add up to "Used", and the safe cleanup items to "Safe to free".
    $tiles = [
        ['label' => 'Disk size', 'value' => '994.7 GB', 'hide' => null],
        ['label' => 'Used', 'value' => '871.2 GB', 'hide' => null],
        ['label' => 'Free now', 'value' => '123.5 GB', 'hide' => 'max-sm:hidden'],
        ['label' => 'Safe to free', 'value' => '64.8 GB', 'hide' => 'max-lg:hidden', 'green' => true],
        ['label' => 'Free after the safe steps', 'value' => '188.3 GB', 'hide' => 'max-lg:hidden'],
    ];
    $total = 994.7;
    $slices = [
        ['name' => '~/Documents', 'gb' => 182.4, 'area' => 'home'],
        ['name' => 'Other app data (~/Library)', 'gb' => 141.0, 'area' => 'library'],
        ['name' => 'System Data & other (not scanned)', 'gb' => 118.6, 'area' => 'system'],
        ['name' => 'Xcode & simulators (~/Library/Developer)', 'gb' => 96.3, 'area' => 'library'],
        ['name' => 'Applications', 'gb' => 74.9, 'area' => 'apps'],
        ['name' => '~/Pictures', 'gb' => 61.5, 'area' => 'home'],
        ['name' => '~/Downloads', 'gb' => 52.7, 'area' => 'home'],
        ['name' => 'Mail', 'gb' => 38.2, 'area' => 'library'],
        ['name' => 'Docker Desktop data', 'gb' => 33.0, 'area' => 'library'],
        ['name' => 'App caches', 'gb' => 27.4, 'area' => 'library'],
        ['name' => 'iOS simulator runtimes', 'gb' => 21.8, 'area' => 'system'],
        ['name' => 'Other home folders', 'gb' => 13.8, 'area' => 'home'],
        ['name' => 'Homebrew', 'gb' => 9.6, 'area' => 'system'],
    ];
    $areas = [
        'home' => ['label' => 'Home folders', 'bg' => 'bg-area-home'],
        'library' => ['label' => 'App data (~/Library)', 'bg' => 'bg-area-library'],
        'apps' => ['label' => 'Applications', 'bg' => 'bg-area-apps'],
        'system' => ['label' => 'macOS & system', 'bg' => 'bg-area-system'],
    ];
    $cleanup = [
        ['title' => 'App caches', 'detail' => 'Apps rebuild their caches. Quit big apps first.', 'size' => '27.4 GB', 'safe' => true, 'button' => 'Clean…'],
        ['title' => 'node_modules in 38 projects', 'detail' => 'Pick the projects to clean; npm install brings them back.', 'size' => '18.6 GB', 'safe' => true, 'button' => 'Choose…'],
        ['title' => 'Xcode DerivedData', 'detail' => 'Build products Xcode recreates.', 'size' => '11.2 GB', 'safe' => true, 'button' => 'Clean…'],
        ['title' => 'Empty the Trash', 'detail' => 'Same as Finder → Empty Trash.', 'size' => '4.9 GB', 'safe' => true, 'button' => 'Clean…'],
        ['title' => 'npm cache', 'detail' => 'npm downloads packages again when needed.', 'size' => '2.7 GB', 'safe' => true, 'button' => 'Clean…'],
        ['title' => 'Downloads folder', 'detail' => 'Sort by size in Finder; delete installers and old exports.', 'size' => '52.7 GB', 'safe' => false, 'button' => 'Show in Finder'],
        ['title' => 'Mail downloads & attachments', 'detail' => 'Remove unused accounts in Mail → Settings → Accounts.', 'size' => '38.2 GB', 'safe' => false, 'button' => 'Show in Finder'],
    ];
    $card = 'rounded-lg bg-white p-3 ring-1 ring-neutral-950/10 sm:p-4';
    $percent = fn (float $gb) => round(100 * $gb / $total, 2);
@endphp

{{-- A mock of the Wombat window. Hovering the usage bar names each part, like in the app (resources/js/app.js). --}}
<div {{ $attributes->class('overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-burrow-950/10') }}>
    <div class="flex items-center gap-x-5 border-b border-neutral-950/5 bg-neutral-50 px-4 py-3" aria-hidden="true">
        <div class="flex gap-x-2">
            <div class="size-3 rounded-full bg-[#ff5f57]"></div>
            <div class="size-3 rounded-full bg-[#febc2e]"></div>
            <div class="size-3 rounded-full bg-[#28c840]"></div>
        </div>
        <div class="text-sm/5 font-semibold">Wombat</div>
        <x-heroicon-c-arrow-path class="ml-auto size-4 shrink-0 fill-neutral-500" />
    </div>

    <div class="relative max-h-[30rem] overflow-hidden bg-neutral-100/70 p-4 text-xs/5 sm:max-h-[34rem] sm:p-6 sm:text-sm/5">
        <div aria-hidden="true">
            <div class="font-serif text-2xl text-neutral-900 sm:text-3xl">Mac disk usage</div>
            <p class="mt-1 text-neutral-500">Your disk is 87.6% full with 123.5 GB free. About 64.8 GB can be freed safely, and 94.0 GB more once you check what you still need.</p>

            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($tiles as $tile)
                    <div class="{{ $card }} {{ $tile['hide'] }}">
                        <div class="truncate text-xs/4 text-neutral-500">{{ $tile['label'] }}</div>
                        <div @class(['mt-1 font-serif text-lg tabular-nums sm:text-xl', 'text-green-600' => $tile['green'] ?? false])>{{ $tile['value'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="{{ $card }} mt-3" data-usage-bar>
            <div class="font-semibold text-neutral-900">Where the space goes</div>
            <div class="group mt-3 flex h-8 gap-px overflow-hidden rounded-md" data-usage-segments>
                @foreach ($slices as $slice)
                    <div class="{{ $areas[$slice['area']]['bg'] }} w-(--share) shrink-0 transition-opacity duration-150 group-data-hovering:opacity-40 data-hovered:opacity-100!"
                         style="--share: {{ $percent($slice['gb']) }}%"
                         data-slice="{{ $slice['name'] }}: {{ number_format($slice['gb'], 1) }} GB · {{ number_format($percent($slice['gb']), 1) }}%"></div>
                @endforeach
                <div class="grow bg-neutral-200 transition-opacity duration-150 group-data-hovering:opacity-40 data-hovered:opacity-100!" data-slice="Free: 123.5 GB · 12.4%"></div>
            </div>
            <p class="mt-2 h-5 truncate text-neutral-500" data-usage-label aria-hidden="true">Hover the bar to see each part.</p>
            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs/4 text-neutral-500" aria-hidden="true">
                @foreach ($areas as $area)
                    <span class="flex items-center gap-x-1.5"><span class="size-2.5 rounded-xs {{ $area['bg'] }}"></span>{{ $area['label'] }}</span>
                @endforeach
                <span class="flex items-center gap-x-1.5"><span class="size-2.5 rounded-xs bg-neutral-200"></span>Free</span>
            </div>
        </div>

        <div class="mt-3 grid grid-cols-1 gap-3 lg:grid-cols-[minmax(0,2fr)_minmax(0,3fr)]" aria-hidden="true">
            <div class="{{ $card }} max-lg:hidden">
                <div class="font-semibold text-neutral-900">By category</div>
                <ul class="mt-3 space-y-2 tabular-nums">
                    @foreach ($slices as $slice)
                        <li class="flex items-center gap-x-3">
                            <span class="min-w-0 grow truncate">{{ $slice['name'] }}</span>
                            <span class="w-24 shrink-0"><span class="block h-2 w-(--share) min-w-0.5 rounded-full {{ $areas[$slice['area']]['bg'] }}" style="--share: {{ round(100 * $slice['gb'] / 182.4, 2) }}%"></span></span>
                            <span class="w-16 shrink-0 text-right">{{ number_format($slice['gb'], 1) }} GB</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="{{ $card }}">
                <div class="font-semibold text-neutral-900">What you can free</div>
                <ul class="mt-1 divide-y divide-neutral-950/5">
                    @foreach ($cleanup as $item)
                        <li class="flex items-start gap-x-3 py-2.5">
                            <div class="min-w-0 grow">
                                <div class="truncate">{{ $item['title'] }}</div>
                                <div class="truncate text-xs/4 text-neutral-500">{{ $item['detail'] }}</div>
                            </div>
                            <span class="shrink-0 tabular-nums">{{ $item['size'] }}</span>
                            <span @class([
                                'shrink-0 rounded-full px-1.5 text-xs/4 ring-1 max-sm:hidden',
                                'text-green-600 ring-green-600' => $item['safe'],
                                'text-orange-500 ring-orange-500' => ! $item['safe'],
                            ])>{{ $item['safe'] ? 'Safe' : 'Check first' }}</span>
                            <span class="w-24 shrink-0 text-right max-sm:hidden"><span class="rounded-md bg-white px-2 py-0.5 text-xs/4 shadow-xs ring-1 ring-neutral-950/10">{{ $item['button'] }}</span></span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- The window carries on below, like in the app. --}}
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-16 bg-linear-to-t from-neutral-100"></div>
    </div>
</div>
