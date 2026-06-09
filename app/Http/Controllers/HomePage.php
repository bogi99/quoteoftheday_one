<?php

namespace App\Http\Controllers;

use App\Models\Quotes;
use Illuminate\Support\Facades\Concurrency;


class HomePage extends Controller
{
    public function index()
    {
        [$count, $quote] = Concurrency::run([
            fn () => Quotes::query()->count('id'),
            fn () => Quotes::query()->inRandomOrder('')->first(['id', 'quote', 'author']),
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

