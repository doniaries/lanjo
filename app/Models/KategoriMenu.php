<?php

namespace App\Models;

use App\Traits\BelongsToUsaha;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriMenu extends Model
{
    use BelongsToUsaha;

    protected $guarded = [];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}

