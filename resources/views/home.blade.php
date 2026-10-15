@php
    $download = url('/download');
    $repository = config('wombat.repository_url');

    $features = [
        ['icon' => 'chart-bar', 'title' => 'The whole disk at a glance', 'body' => 'One bar for the entire disk, largest parts first. Hover a part to see what it is and how much it takes.'],
        ['icon' => 'map', 'title' => 'Every corner', 'body' => 'Your home folder, ~/Library, Applications, Homebrew and iOS simulator runtimes, measured in one go.'],
        ['icon' => 'folder-open', 'title' => 'Biggest folders first', 'body' => 'The folders that take the most space in your home and in ~/Library, so you know where to start.'],
        ['icon' => 'question-mark-circle', 'title' => 'System Data, explained', 'body' => 'What macOS calls System Data is shown as what Wombat can’t measure, not as a mystery number.'],
        ['icon' => 'cursor-arrow-rays', 'title' => 'Show in Finder', 'body' => 'Double-click any row to open it in Finder and take a closer look yourself.'],
        ['icon' => 'code-bracket', 'title' => 'Made for developers', 'body' => 'Finds old node_modules and Composer vendor folders, Xcode DerivedData, Docker images and simulator leftovers.'],
        ['icon' => 'lock-closed', 'title' => 'Knows what it can’t see', 'body' => 'Without Full Disk Access some folders look smaller than they are. Wombat tells you, and takes you to the setting.'],
        ['icon' => 'arrow-path', 'title' => 'Dig as deep as you like', 'body' => 'Wombats dig burrows up to 30 metres long. Pick a quick look at your disk, the slower search for project folders, or both.'],
    ];

    $safe = [
        ['title' => 'Trash and app caches', 'body' => 'Apps rebuild their caches when they need them.'],
        ['title' => 'Xcode leftovers', 'body' => 'DerivedData, iOS DeviceSupport and unavailable simulators.'],
        ['title' => 'npm cache', 'body' => 'Packages download again when a project needs them.'],
        ['title' => 'node_modules', 'body' => 'Pick the projects you’re not working on; npm install brings them back.'],
    ];

    $check = [
        ['title' => 'Downloads', 'body' => 'Opens in Finder, sorted by size, for you to go through.'],
        ['title' => 'Mail attachments', 'body' => 'Points you to the Mail setting that keeps them from piling up.'],
        ['title' => 'Docker images', 'body' => 'Removes unused images and stopped containers, and keeps your volumes.'],
        ['title' => 'Simulator runtimes, Ollama models, vendor folders', 'body' => 'Things you may still use, shown so you can decide.'],
    ];

    // Feedback from people using Wombat, one quote per line. The section stays hidden while this is empty.
    $testimonials = [];
@endphp

<x-layouts.app>
    <div class="absolute inset-x-0 top-0 -z-10 h-[44rem] bg-linear-to-b from-burrow-50 to-white"></div>

    <x-site-header />

    <main>
        {{-- Hero --}}
        <section class="relative pt-10 pb-24 sm:pt-16 sm:pb-32">
            <div class="mx-auto max-w-6xl px-6 text-center lg:px-8">
                <img src="{{ asset('images/wombat.webp') }}" width="384" height="384" fetchpriority="high" alt="The Wombat app icon: a wombat peeking over a Mac drive" class="mx-auto size-32 sm:size-40">
                <h1 class="mx-auto mt-8 max-w-[20ch] font-display text-5xl font-semibold tracking-tight text-balance text-burrow-950 sm:text-7xl">
                    Dig up where your disk space went
                </h1>
                <p class="mx-auto mt-6 max-w-[48ch] text-lg/8 text-pretty text-neutral-600 sm:text-xl/8">
                    Wombat is a small, native disk space app for your Mac. It digs through your disk, shows what fills it and helps you clear out caches, build leftovers and old node_modules, without touching anything you didn’t pick.
                </p>
                <div class="mt-10 flex flex-wrap items-center justify-center gap-x-8 gap-y-4">
                    <a href="{{ $download }}" class="inline-flex items-center gap-x-2 rounded-full bg-burrow-600 py-3 pr-5 pl-4 text-base/6 font-semibold text-white shadow-sm hover:bg-burrow-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-burrow-600">
                        <x-heroicon-m-arrow-down-tray class="size-5 shrink-0 fill-white" />
                        <span>Download for Mac<span aria-hidden="true">*</span></span>
                    </a>
                    <a href="{{ $repository }}" class="inline-flex items-center gap-x-1.5 text-base/6 font-semibold text-burrow-800 hover:text-burrow-600">
                        View on GitHub
                        <x-heroicon-m-arrow-right class="size-5 shrink-0 fill-current" />
                    </a>
                </div>
                <p class="mt-6 text-base/7 text-neutral-500 sm:text-sm/6">Free · Apple Silicon · macOS 14 or later</p>
                <p class="mt-1 text-base/7 text-pretty text-neutral-500 sm:text-sm/6">
                    <span aria-hidden="true">*</span>Wombat isn’t notarized by Apple, so the first launch needs one extra step.
                    <a href="#install" class="font-medium whitespace-nowrap text-burrow-700 hover:text-burrow-600">See how <span aria-hidden="true">↓</span></a>
                </p>

                <x-app-window class="mx-auto mt-16 max-w-5xl text-left sm:mt-20" />
            </div>
        </section>

        {{-- Cleanup --}}
        <section id="cleanup" class="scroll-mt-8 bg-burrow-950 py-24 sm:py-32">
            <div class="mx-auto max-w-6xl px-6 lg:px-8">
                <p class="text-base/7 font-semibold text-burrow-300">Cleanup</p>
                <h2 class="mt-2 max-w-[24ch] font-display text-4xl font-semibold tracking-tight text-balance text-white sm:text-5xl">
                    Clear out the clutter, keep what matters
                </h2>
                <p class="mt-6 max-w-[52ch] text-lg/8 text-pretty text-burrow-100/70">
                    Wombat sorts what it finds into two piles. Safe things rebuild themselves, so you can clean them with a click. Everything else is yours to check first. Nothing is deleted without asking, and nothing you didn’t pick.
                </p>

                <div class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 lg:grid-cols-2">
                    <div class="rounded-2xl bg-white/5 p-8 ring-1 ring-white/10">
                        <div class="flex items-center gap-x-3">
                            <span class="rounded-full px-2 text-sm/6 font-medium text-green-400 ring-1 ring-green-400/60">Safe</span>
                            <span class="text-base/7 font-semibold text-white">Clean with a click</span>
                        </div>
                        <dl class="mt-8 space-y-6">
                            @foreach ($safe as $item)
                                <div>
                                    <dt class="flex items-start gap-x-3 text-base/7 font-semibold text-white">
                                        <x-heroicon-m-check-circle class="size-5 h-lh shrink-0 fill-green-400" />
                                        {{ $item['title'] }}
                                    </dt>
                                    <dd class="mt-1 pl-8 text-base/7 text-pretty text-burrow-100/70">{{ $item['body'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                    <div class="rounded-2xl bg-white/5 p-8 ring-1 ring-white/10">
                        <div class="flex items-center gap-x-3">
                            <span class="rounded-full px-2 text-sm/6 font-medium text-orange-300 ring-1 ring-orange-300/60">Check first</span>
                            <span class="text-base/7 font-semibold text-white">You decide</span>
                        </div>
                        <dl class="mt-8 space-y-6">
                            @foreach ($check as $item)
                                <div>
                                    <dt class="flex items-start gap-x-3 text-base/7 font-semibold text-white">
                                        <x-heroicon-m-eye class="size-5 h-lh shrink-0 fill-orange-300" />
                                        {{ $item['title'] }}
                                    </dt>
                                    <dd class="mt-1 pl-8 text-base/7 text-pretty text-burrow-100/70">{{ $item['body'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                </div>

                <p class="mt-12 max-w-[60ch] text-base/7 text-pretty text-burrow-100/70">
                    When a size is only an upper bound, like everything Docker keeps on disk, Wombat says “up to” and leaves it out of the totals, so the space it promises is space you’ll actually get back.
                </p>
            </div>
        </section>

        {{-- Features --}}
        <section id="features" class="scroll-mt-8 py-24 sm:py-32">
            <div class="mx-auto max-w-6xl px-6 lg:px-8">
                <p class="text-base/7 font-semibold text-burrow-600">Features</p>
                <h2 class="mt-2 max-w-[30ch] font-display text-4xl font-semibold tracking-tight text-balance text-burrow-950 sm:text-5xl">
                    Everything you need, nothing you don’t
                </h2>
                <p class="mt-6 max-w-[48ch] text-lg/8 text-pretty text-neutral-600">
                    Pick how deep Wombat digs, and you soon know where your space went and what you can get back. It keeps the last dig, so the next time you open it, the answer is already there.
                </p>

                <dl class="mt-16 grid grid-cols-1 gap-x-12 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($features as $feature)
                        <div>
                            <dt class="flex items-start gap-x-3 text-base/7 font-semibold text-burrow-950">
                                <x-dynamic-component :component="'heroicon-m-'.$feature['icon']" class="size-5 h-lh shrink-0 fill-burrow-500" />
                                {{ $feature['title'] }}
                            </dt>
                            <dd class="mt-1 pl-8 text-base/7 text-pretty text-neutral-600">{{ $feature['body'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>
        </section>

        {{-- Testimonials --}}
        @if ($testimonials)
            <section class="pb-24 sm:pb-32">
                <div class="mx-auto max-w-6xl px-6 lg:px-8">
                    <p class="text-base/7 font-semibold text-burrow-600">Kind words</p>
                    <h2 class="mt-2 max-w-[30ch] font-display text-4xl font-semibold tracking-tight text-balance text-burrow-950 sm:text-5xl">
                        What people say about Wombat
                    </h2>

                    <div class="mt-16 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($testimonials as $quote)
                            <figure class="rounded-2xl bg-burrow-50 p-8 ring-1 ring-burrow-950/5">
                                <svg viewBox="0 0 32 24" aria-hidden="true" class="h-6 fill-burrow-300"><path d="M0 24V14.4C0 6.24 4.48 1.44 12.8 0l1.28 3.2C9.6 4.48 7.36 7.04 7.04 11.2H12.8V24H0Zm19.2 0V14.4C19.2 6.24 23.68 1.44 32 0l1.28 3.2c-4.48 1.28-6.72 3.84-7.04 8H32V24H19.2Z"/></svg>
                                <blockquote class="mt-6 text-lg/8 text-pretty text-burrow-950">
                                    <p>{{ $quote }}</p>
                                </blockquote>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Under the hood --}}
        <section class="bg-burrow-50 py-24 sm:py-32">
            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-x-12 gap-y-16 px-6 lg:grid-cols-2 lg:px-8">
                <div>
                    <p class="text-base/7 font-semibold text-burrow-600">Under the hood</p>
                    <h2 class="mt-2 max-w-[30ch] font-display text-4xl font-semibold tracking-tight text-balance text-burrow-950 sm:text-5xl">
                        Small, native, and stays on your Mac
                    </h2>
                    <p class="mt-6 max-w-[48ch] text-lg/8 text-pretty text-neutral-600">
                        Wombat is written in Swift and SwiftUI, so it looks and feels like it belongs on your Mac. It measures with the tools macOS already has, like du, find and diskutil, and never connects to the internet. What it finds about your disk stays on your disk.
                    </p>
                </div>
                <dl class="divide-y divide-burrow-950/10 self-center">
                    <div class="flex items-baseline justify-between gap-x-6 pb-6">
                        <dt class="text-base/7 text-neutral-600">Download size</dt>
                        <dd class="font-display text-2xl font-semibold tracking-tight text-burrow-950 tabular-nums">About 1 MB</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-x-6 py-6">
                        <dt class="text-base/7 text-neutral-600">Ads, accounts and analytics</dt>
                        <dd class="font-display text-2xl font-semibold tracking-tight text-burrow-950">None</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-x-6 py-6">
                        <dt class="text-base/7 text-neutral-600">Internet connection</dt>
                        <dd class="font-display text-2xl font-semibold tracking-tight text-burrow-950">Never</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-x-6 py-6">
                        <dt class="text-base/7 text-neutral-600">Deletes without asking</dt>
                        <dd class="font-display text-2xl font-semibold tracking-tight text-burrow-950">Never</dd>
                    </div>
                    <div class="flex items-baseline justify-between gap-x-6 pt-6">
                        <dt class="text-base/7 text-neutral-600">Source code</dt>
                        <dd class="font-display text-2xl font-semibold tracking-tight">
                            <a href="{{ $repository }}" class="text-burrow-700 underline decoration-burrow-300 underline-offset-4 hover:decoration-burrow-600">GitHub</a>
                        </dd>
                    </div>
                </dl>
            </div>
        </section>

        {{-- Install --}}
        <section id="install" class="scroll-mt-8 py-24 sm:py-32">
            <div class="mx-auto max-w-6xl px-6 lg:px-8">
                <p class="text-base/7 font-semibold text-burrow-600">Install</p>
                <h2 class="mt-2 max-w-[30ch] font-display text-4xl font-semibold tracking-tight text-balance text-burrow-950 sm:text-5xl">
                    Let Wombat move in
                </h2>
                <p class="mt-6 max-w-[48ch] text-lg/8 text-pretty text-neutral-600">
                    Wombat isn’t on the App Store and isn’t notarized by Apple, so macOS asks you to confirm it the first time. It takes about a minute, and you only do it once.
                </p>

                <ol role="list" class="mt-16 grid grid-cols-1 gap-x-12 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
                    <li>
                        <div class="font-display text-base/7 font-semibold text-burrow-600 tabular-nums">01</div>
                        <h3 class="mt-2 text-base/7 font-semibold text-burrow-950">Download</h3>
                        <p class="mt-1 text-base/7 text-pretty text-neutral-600">
                            Download <a href="{{ $download }}" class="font-semibold text-burrow-700 underline decoration-burrow-300 underline-offset-4 hover:decoration-burrow-600">Wombat.dmg</a> and open it.
                        </p>
                    </li>
                    <li>
                        <div class="font-display text-base/7 font-semibold text-burrow-600 tabular-nums">02</div>
                        <h3 class="mt-2 text-base/7 font-semibold text-burrow-950">Drag to Applications</h3>
                        <p class="mt-1 text-base/7 text-pretty text-neutral-600">Drag Wombat onto the Applications folder in the window that opens.</p>
                    </li>
                    <li>
                        <div class="font-display text-base/7 font-semibold text-burrow-600 tabular-nums">03</div>
                        <h3 class="mt-2 text-base/7 font-semibold text-burrow-950">Open Anyway</h3>
                        <p class="mt-1 text-base/7 text-pretty text-neutral-600">
                            Open Wombat. When macOS says it can’t verify the developer, go to System Settings → Privacy &amp; Security, scroll down and click Open Anyway.
                        </p>
                    </li>
                    <li>
                        <div class="font-display text-base/7 font-semibold text-burrow-600 tabular-nums">04</div>
                        <h3 class="mt-2 text-base/7 font-semibold text-burrow-950">Full Disk Access</h3>
                        <p class="mt-1 text-base/7 text-pretty text-neutral-600">
                            In System Settings → Privacy &amp; Security → Full Disk Access, switch Wombat on, then reopen it. Without it, Mail, Messages and some app data look smaller than they are.
                        </p>
                    </li>
                </ol>

                <p class="mt-16 border-t border-neutral-950/5 pt-8 text-base/7 text-neutral-600 sm:text-sm/6">
                    Wombat needs a Mac with Apple Silicon (M1 or newer) and macOS 14 or later. It doesn’t update itself yet: new versions show up in the <a href="/changelog" class="font-medium text-burrow-700 hover:text-burrow-600">changelog</a>.
                </p>
                <p class="mt-2 text-base/7 text-pretty text-neutral-600 sm:text-sm/6">
                    The first time you empty the Trash from Wombat, macOS asks whether it may control Finder. Click OK; that’s how Wombat empties the Trash the same way Finder does.
                </p>
            </div>
        </section>
    </main>

    <x-site-footer />
</x-layouts.app>
