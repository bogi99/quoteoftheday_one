<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Concurrency;

class HomePage extends Controller
{
    private const CACHE_DURATION_MINUTES = 10;

    public function index()
    {
        // Benchmark reference: previous approach kept for easy rollback/compare.
        // [$count, $quote] = Concurrency::run([
        //     fn () => Quotes::query()->count('id'),
        //     fn () => Quotes::query()->inRandomOrder('')->first(['id', 'quote', 'author']),
        // ]);

        [$count, $quote] = Concurrency::run([
            fn () => Cache::remember('quotes:count', now()->addMinutes(self::CACHE_DURATION_MINUTES), fn () => Quotes::query()->count('id')),
            function () {
                $bounds = Cache::remember('quotes:id-bounds', now()->addMinutes(self::CACHE_DURATION_MINUTES), function () {
                    $result = Quotes::query()
                        ->selectRaw('MIN(id) as min_id, MAX(id) as max_id')
                        ->first();

                    if (! $result?->min_id || ! $result?->max_id) {
                        return null;
                    }

                    return [
                        'min_id' => (int) $result->min_id,
                        'max_id' => (int) $result->max_id,
                    ];
                });

                if (! $bounds || ! isset($bounds['min_id'], $bounds['max_id'])) {
                    return null;
                }

                $randomId = random_int($bounds['min_id'], $bounds['max_id']);

                return Quotes::query()
                    ->where('id', '>=', $randomId)
                    ->first(['id', 'quote', 'author'])
                    ?? Quotes::query()->orderBy('id')->first(['id', 'quote', 'author']);
            },
        ]);

        $authorWikipediaUrl = null;

        if ($quote?->author) {
            $sanitizedAuthor = trim($quote->author);
            $sanitizedAuthor = preg_replace('/\s+/u', ' ', $sanitizedAuthor) ?? $sanitizedAuthor;
            $sanitizedAuthor = preg_replace('/[,.;:!?]+$/u', '', $sanitizedAuthor) ?? $sanitizedAuthor;

            if ($sanitizedAuthor !== '') {
                $authorWikipediaUrl = 'https://en.wikipedia.org/wiki/'.str_replace('%20', '_', rawurlencode($sanitizedAuthor));
            }
        }

        return view('index', [
            'count' => $count,
            'quote' => $quote,
            'authorWikipediaUrl' => $authorWikipediaUrl,
        ]);
    }
}
