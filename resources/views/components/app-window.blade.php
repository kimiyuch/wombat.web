@php
    // A made-up 1 TB Mac. The slices add up to "Used", and the cards' totals to "Safe to free" and the "Check first" sum.
    $stats = [
        ['label' => 'Used', 'value' => '871.2 GB', 'class' => 'text-white'],
        ['label' => 'Safe to free', 'value' => '64.8 GB', 'class' => 'text-green-400'],
        ['label' => 'Free after the safe steps', 'value' => '188.3 GB', 'class' => 'text-white'],
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
    $piles = [
        [
            'pill' => 'Safe', 'title' => 'Clean with a click', 'total' => '64.8 GB', 'safe' => true,
            'items' => [
                ['icon' => 'archive-box', 'title' => 'App caches', 'detail' => 'Apps rebuild their caches. Quit big apps first.', 'size' => '27.4 GB', 'button' => 'Clean…'],
                ['icon' => 'cube', 'title' => 'node_modules in 38 projects', 'detail' => 'Pick the projects to clean; npm install brings them back.', 'size' => '18.6 GB', 'button' => 'Choose…'],
                ['icon' => 'wrench-screwdriver', 'title' => 'Xcode DerivedData', 'detail' => 'Build products Xcode recreates.', 'size' => '11.2 GB', 'button' => 'Clean…'],
                ['icon' => 'trash', 'title' => 'Empty the Trash', 'detail' => 'Same as Finder → Empty Trash.', 'size' => '4.9 GB', 'button' => 'Clean…'],
                ['icon' => 'archive-box-arrow-down', 'title' => 'npm cache', 'detail' => 'npm downloads packages again when needed.', 'size' => '2.7 GB', 'button' => 'Clean…', 'command' => 'npm cache clean --force'],
            ],
        ],
        [
            'pill' => 'Check first', 'title' => 'You decide', 'total' => '94.0 GB', 'safe' => false,
            'items' => [
                ['icon' => 'arrow-down-circle', 'title' => 'Downloads folder', 'detail' => 'Sort by size in Finder; delete installers and old exports.', 'size' => '52.7 GB', 'button' => 'Show in Finder'],
                ['icon' => 'envelope', 'title' => 'Mail downloads & attachments', 'detail' => 'Remove unused accounts in Mail → Settings → Accounts.', 'size' => '38.2 GB', 'button' => 'Show in Finder'],
                ['icon' => 'cube-transparent', 'title' => 'Docker images & stopped containers', 'detail' => 'Unused images are pulled again when needed. Volumes are kept.', 'size' => 'up to 33.0 GB', 'button' => 'Clean…', 'command' => 'docker system prune -a -f'],
                ['icon' => 'sparkles', 'title' => 'Ollama models', 'detail' => 'Remove models you no longer use.', 'size' => '3.1 GB', 'button' => 'Show in Finder'],
            ],
        ],
    ];
    $percent = fn (float $gb) => round(100 * $gb / $total, 2);
@endphp

{{-- A mock of the Wombat window. Hovering the usage bar names each part, like in the app (resources/js/app.js). --}}
<div {{ $attributes->class('overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-burrow-950/10') }}>
    <div class="relative max-h-[34rem] overflow-hidden text-xs/5 sm:max-h-[44rem] sm:text-sm/5">
        {{-- The dark panel at the top of the window --}}
        <div class="border-b border-white/10 bg-linear-to-b from-burrow-900 to-burrow-950 px-4 pt-3 pb-5 sm:px-6 sm:pb-6" data-usage-bar>
            <div aria-hidden="true">
                <div class="flex gap-x-2">
                    <div class="size-3 rounded-full bg-[#ff5f57]"></div>
                    <div class="size-3 rounded-full bg-[#febc2e]"></div>
                    <div class="size-3 rounded-full bg-[#28c840]"></div>
                </div>

                <div class="mt-4 flex items-center gap-x-3">
                    <img src="{{ asset('images/wombat.webp') }}" alt="" class="size-7 sm:size-8">
                    <div class="font-display text-base font-semibold text-white">Wombat</div>
                    <div class="ml-auto text-burrow-100/70 max-sm:hidden">Last dug 3 hours ago</div>
                    <span class="inline-flex items-center gap-x-1.5 rounded-full bg-white px-3 py-1 font-semibold text-burrow-950 max-sm:ml-auto">
                        <x-heroicon-m-arrow-path class="size-4 shrink-0 fill-burrow-950" />
                        Dig again
                    </span>
                </div>

                <div class="mt-6 flex flex-wrap items-end justify-between gap-6">
                    <div>
                        <div class="font-semibold text-burrow-300">Free now</div>
                        <div class="mt-1 font-display text-4xl font-semibold tracking-tight text-white tabular-nums sm:text-5xl">123.5 GB</div>
                        <div class="mt-1 text-burrow-100/70 sm:text-base/6">of 994.7 GB · 87.6% full</div>
                    </div>
                    <dl class="flex divide-x divide-white/10 max-md:hidden">
                        @foreach ($stats as $stat)
                            <div class="px-5 last:pr-0">
                                <dt class="text-xs/4 text-burrow-100/70">{{ $stat['label'] }}</dt>
                                <dd class="mt-1 font-display text-xl font-semibold tabular-nums {{ $stat['class'] }}">{{ $stat['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>

            <div class="group mt-6 flex h-8 gap-px overflow-hidden rounded-md" data-usage-segments>
                @foreach ($slices as $slice)
                    <div class="{{ $areas[$slice['area']]['bg'] }} w-(--share) shrink-0 transition-opacity duration-150 group-data-hovering:opacity-40 data-hovered:opacity-100!"
                         style="--share: {{ $percent($slice['gb']) }}%"
                         data-slice="{{ $slice['name'] }}: {{ number_format($slice['gb'], 1) }} GB · {{ number_format($percent($slice['gb']), 1) }}%"></div>
                @endforeach
                <div class="grow bg-white/10 transition-opacity duration-150 group-data-hovering:opacity-40 data-hovered:opacity-100!" data-slice="Free: 123.5 GB · 12.4%"></div>
            </div>
            <p class="mt-2 h-5 truncate text-burrow-100/70" data-usage-label aria-hidden="true">Hover the bar to see each part.</p>
            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs/4 text-burrow-100/70" aria-hidden="true">
                @foreach ($areas as $area)
                    <span class="flex items-center gap-x-1.5"><span class="size-2.5 rounded-xs {{ $area['bg'] }}"></span>{{ $area['label'] }}</span>
                @endforeach
                <span class="flex items-center gap-x-1.5"><span class="size-2.5 rounded-xs bg-white/10"></span>Free</span>
            </div>
        </div>

        {{-- The cleanup section below it --}}
        <div class="bg-linear-to-b from-burrow-50 to-white px-4 pt-6 pb-16 sm:px-6 sm:pt-8" aria-hidden="true">
            <div class="font-semibold text-burrow-600">Cleanup</div>
            <div class="mt-1 font-display text-xl font-semibold tracking-tight text-burrow-950 sm:text-2xl">Clear out the clutter, keep what matters</div>
            <p class="mt-2 max-w-[60ch] text-neutral-500">About 64.8 GB can be freed safely, and 94.0 GB more once you check what you still need. Nothing is deleted without asking.</p>

            <div class="mt-5 grid grid-cols-1 gap-4 lg:grid-cols-2">
                @foreach ($piles as $pile)
                    <div @class(['rounded-lg bg-white px-4 pt-3 ring-1 ring-burrow-950/10 sm:px-5 sm:pt-4', 'max-lg:hidden' => ! $pile['safe']])>
                        <div class="flex items-center gap-x-2.5 pb-2">
                            <span @class([
                                'rounded-full px-1.5 text-xs/4 font-medium ring-1',
                                'text-green-600 ring-green-600/60' => $pile['safe'],
                                'text-orange-500 ring-orange-500/60' => ! $pile['safe'],
                            ])>{{ $pile['pill'] }}</span>
                            <span class="font-display font-semibold text-burrow-950 sm:text-base">{{ $pile['title'] }}</span>
                            <span @class([
                                'ml-auto font-display font-semibold tabular-nums sm:text-base',
                                'text-green-600' => $pile['safe'],
                                'text-orange-500' => ! $pile['safe'],
                            ])>{{ $pile['total'] }}</span>
                        </div>
                        <ul class="divide-y divide-neutral-950/5 border-t border-neutral-950/5">
                            @foreach ($pile['items'] as $item)
                                <li class="flex items-start gap-x-3 py-3">
                                    <span @class([
                                        'grid size-7 shrink-0 place-items-center rounded-md',
                                        'bg-burrow-600/10' => $pile['safe'],
                                        'bg-orange-500/10' => ! $pile['safe'],
                                    ])>
                                        <x-dynamic-component :component="'heroicon-m-'.$item['icon']" @class(['size-4', 'fill-burrow-600' => $pile['safe'], 'fill-orange-500' => ! $pile['safe']]) />
                                    </span>
                                    <div class="min-w-0 grow">
                                        <div class="truncate font-medium text-burrow-950">{{ $item['title'] }}</div>
                                        <div class="truncate text-xs/4 text-neutral-500">{{ $item['detail'] }}</div>
                                        @isset($item['command'])
                                            <code class="mt-1 inline-block rounded-sm bg-burrow-50 px-1 font-mono text-xs/4 text-burrow-700">{{ $item['command'] }}</code>
                                        @endisset
                                    </div>
                                    <div class="flex shrink-0 flex-col items-end gap-y-1.5">
                                        <span class="font-display font-medium text-burrow-950 tabular-nums">{{ $item['size'] }}</span>
                                        <span @class([
                                            'rounded-full px-2.5 py-0.5 text-xs/4 font-semibold',
                                            'bg-burrow-600 text-white' => $item['button'] !== 'Show in Finder',
                                            'bg-white text-burrow-700 ring-1 ring-burrow-950/10' => $item['button'] === 'Show in Finder',
                                        ])>{{ $item['button'] }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- The window carries on below, like in the app. --}}
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-20 bg-linear-to-t from-white"></div>
    </div>
</div>
