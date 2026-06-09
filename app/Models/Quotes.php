<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    /** @use HasFactory<\Database\Factories\QuotesFactory> */
    use HasFactory;
    protected $fillable = [
        'quote',
        'author',
    ];
    
}
