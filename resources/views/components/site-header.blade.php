@php($repository = config('wombat.repository_url'))

<header class="mx-auto flex max-w-6xl items-center justify-between gap-x-6 px-6 py-5 lg:px-8">
    <a href="/" aria-label="Homepage" class="font-display text-xl font-semibold text-burrow-950">Wombat</a>
    <nav class="flex items-center gap-x-8">
        <a href="/#cleanup" class="text-sm/6 font-medium text-neutral-700 hover:text-burrow-700 max-sm:hidden">Cleanup</a>
        <a href="/#features" class="text-sm/6 font-medium text-neutral-700 hover:text-burrow-700 max-sm:hidden">Features</a>
        <a href="/#install" class="text-sm/6 font-medium text-neutral-700 hover:text-burrow-700 max-sm:hidden">Install</a>
        <a href="{{ $repository }}" class="rounded-full px-3 py-1.5 text-sm/6 font-medium text-burrow-800 ring-1 ring-burrow-950/10 hover:bg-burrow-50">GitHub</a>
    </nav>
</header>
