<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'phonecode'
    ];
}
