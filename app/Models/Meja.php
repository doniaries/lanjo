<?php

namespace App\Models;

use App\Traits\BelongsToUsaha;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use BelongsToUsaha;

    protected $guarded = [];

    protected $casts = [
        'status' => 'string',
    ];
}

