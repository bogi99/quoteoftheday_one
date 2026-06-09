@props(['count' => 0 , 'quote' => null, 'authorWikipediaUrl' => null])

<div>
    <p class="text-sm text-zinc-700 dark:text-zinc-300">
        Available quotes: {{ $count }}
    </p>

    @if ($quote)
        <p class="mt-4 text-lg text-zinc-900 dark:text-zinc-100">
            "{{ $quote->quote }}"
        </p>
        <p class="mt-2 text-sm text-zinc-700 dark:text-zinc-300">
            -
            @if ($authorWikipediaUrl)
                <a href="{{ $authorWikipediaUrl }}" target="_blank" rel="noopener noreferrer"
                    class="underline decoration-zinc-400 underline-offset-2 hover:text-zinc-900 dark:hover:text-zinc-100">
                    {{ $quote->author }}
                </a>
            @else
                {{ $quote->author }}
            @endif
        </p>
    @else
        <p class="mt-4 text-sm text-zinc-700 dark:text-zinc-300">
            No quotes available yet.
        </p>
    @endif
</div>