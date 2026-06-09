<header {{ $attributes->class(['w-full']) }}>
    <div class="w-full border-b border-zinc-200 bg-white px-4 py-3 dark:border-zinc-700 dark:bg-zinc-950 sm:px-6">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-3" aria-label="{{ config('app.name', 'Laravel') }} home">
                <div
                    class="grid h-10 w-10 place-items-center rounded-md border border-zinc-300 bg-white text-sm font-semibold uppercase tracking-widest text-zinc-900 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                    {{ str(config('app.name', 'Laravel'))->substr(0, 2) }}
                </div>
                <span class="text-sm font-medium tracking-wide text-zinc-900 dark:text-zinc-100">
                    {{ config('app.name', 'Laravel') }}
                </span>
            </a>

            @if (\Illuminate\Support\Facades\Route::has('login'))
                <nav class="flex items-center justify-end gap-2 sm:gap-3" aria-label="Authentication">
                    @auth
                        @if (\Illuminate\Support\Facades\Route::has('dashboard'))
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center rounded-sm border border-zinc-300 px-4 py-1.5 text-sm leading-normal text-zinc-900 transition hover:border-zinc-400 dark:border-zinc-700 dark:text-zinc-100 dark:hover:border-zinc-500">
                                Dashboard
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                class="inline-flex items-center rounded-sm border border-transparent px-4 py-1.5 text-sm leading-normal text-zinc-900 transition hover:border-zinc-300 dark:text-zinc-100 dark:hover:border-zinc-700">
                                Log out
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center rounded-sm border border-transparent px-4 py-1.5 text-sm leading-normal text-zinc-900 transition hover:border-zinc-300 dark:text-zinc-100 dark:hover:border-zinc-700">
                            Log in
                        </a>

                        @if (\Illuminate\Support\Facades\Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center rounded-sm border border-zinc-300 px-4 py-1.5 text-sm leading-normal text-zinc-900 transition hover:border-zinc-400 dark:border-zinc-700 dark:text-zinc-100 dark:hover:border-zinc-500">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </div>
    </div>
</header>
