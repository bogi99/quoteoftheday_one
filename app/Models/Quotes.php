<?php

namespace App\Models;

use Database\Factories\QuotesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    /** @use HasFactory<QuotesFactory> */
    use HasFactory;

    protected $fillable = [
        'quote',
        'author',
    ];
}
