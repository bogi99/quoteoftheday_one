<x-layouts.base>
    <x-slot:title>
        Home
    </x-slot>

    <div class="flex min-h-screen flex-col">
        <x-app-titlebar />
        <div class="flex-1">
            <x-app-content-homepage :count="$count" :quote="$quote" :author-wikipedia-url="$authorWikipediaUrl" />
        </div>

        <div class="bg-amber-400">
            <x-app-footer />
        </div>
    </div>
</x-layouts.base>
