<?php

namespace App\Models;

use App\Traits\BelongsToUsaha;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use BelongsToUsaha;

    protected $guarded = [];
}

