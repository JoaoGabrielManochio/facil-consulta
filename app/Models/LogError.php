<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogError extends Model
{
    public $fillable = [
        'route',
        'error',
    ];

    protected $casts = [
        'id' => 'integer',
        'route' => 'string',
        'error' => 'string',
    ];
}
