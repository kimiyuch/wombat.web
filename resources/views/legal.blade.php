@php($repository = config('wombat.repository_url'))

<x-layouts.app title="Legal Notice · Wombat">
    <div class="absolute inset-x-0 top-0 -z-10 h-[44rem] bg-linear-to-b from-burrow-50 to-white"></div>

    <x-site-header />

    <main class="mx-auto max-w-6xl px-6 pt-10 pb-24 sm:pt-16 sm:pb-32 lg:px-8">
        <p class="text-base/7 font-semibold text-burrow-600">Legal notice</p>
        <h1 class="mt-2 max-w-[30ch] font-display text-4xl font-semibold tracking-tight text-balance text-burrow-950 sm:text-5xl">
            The small print
        </h1>
        <p class="mt-6 max-w-[48ch] text-lg/8 text-pretty text-neutral-600">
            Wombat is a free app that helps you clean up your Mac’s disk. Here’s what that means for you, and what it doesn’t.
        </p>

        <div class="mt-16 divide-y divide-neutral-950/5 border-t border-neutral-950/5">
            <section id="deleting" class="grid scroll-mt-8 grid-cols-1 gap-x-12 gap-y-4 py-12 sm:grid-cols-[12rem_1fr]">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-burrow-950">Deleting files</h2>
                <div class="max-w-[65ch] space-y-4 text-base/7 text-pretty text-neutral-600">
                    <p>
                        Wombat only deletes something after you’ve chosen it and confirmed. Most of what it cleans, like caches
                        and build products, is recreated by the apps that made it. Some of it, like node_modules folders and
                        the Trash, is deleted permanently and doesn’t go to the Trash first.
                    </p>
                    <p>
                        Read what each step does before you confirm it, and keep a backup of anything you can’t lose, for
                        example with Time Machine. You decide what Wombat deletes, and you’re responsible for that choice.
                    </p>
                </div>
            </section>

            <section id="warranty" class="grid scroll-mt-8 grid-cols-1 gap-x-12 gap-y-4 py-12 sm:grid-cols-[12rem_1fr]">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-burrow-950">No warranty</h2>
                <div class="max-w-[65ch] space-y-4 text-base/7 text-pretty text-neutral-600">
                    <p>
                        Wombat is provided free of charge and “as is”, without any warranty. To the extent the law allows,
                        we’re not liable for any damage or loss from using it, including lost data.
                    </p>
                </div>
            </section>

            <section id="privacy" class="grid scroll-mt-8 grid-cols-1 gap-x-12 gap-y-4 py-12 sm:grid-cols-[12rem_1fr]">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-burrow-950">Privacy</h2>
                <div class="max-w-[65ch] space-y-4 text-base/7 text-pretty text-neutral-600">
                    <p>
                        Wombat has no accounts, ads or analytics, and doesn’t connect to the internet. What it finds out
                        about your disk stays on your Mac.
                    </p>
                    <p>
                        This website doesn’t use analytics or tracking. It counts how often the download link is clicked,
                        as a number per day, without storing anything about you. It sets a session cookie that the website
                        framework needs to work, and our host keeps the usual server logs.
                    </p>
                </div>
            </section>

            <section id="trademarks" class="grid scroll-mt-8 grid-cols-1 gap-x-12 gap-y-4 py-12 sm:grid-cols-[12rem_1fr]">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-burrow-950">Trademarks</h2>
                <div class="max-w-[65ch] space-y-4 text-base/7 text-pretty text-neutral-600">
                    <p>
                        Mac, macOS and Xcode are trademarks of Apple Inc. Docker is a trademark of Docker, Inc.
                        Wombat isn’t affiliated with or endorsed by either.
                    </p>
                </div>
            </section>

            <section id="contact" class="grid scroll-mt-8 grid-cols-1 gap-x-12 gap-y-4 py-12 sm:grid-cols-[12rem_1fr]">
                <h2 class="font-display text-2xl font-semibold tracking-tight text-burrow-950">Contact</h2>
                <div class="max-w-[65ch] space-y-4 text-base/7 text-pretty text-neutral-600">
                    <p>
                        Wombat is made by <a href="https://kimiyu.ch" class="font-medium text-burrow-800 hover:text-burrow-600">kimiyu.ch</a>.
                        For questions or problems with the app, please
                        <a href="{{ $repository }}/issues" class="font-medium text-burrow-800 hover:text-burrow-600">open an issue on GitHub</a>.
                    </p>
                </div>
            </section>
        </div>
    </main>

    <x-site-footer />
</x-layouts.app>
