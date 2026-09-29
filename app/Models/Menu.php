<?php

namespace App\Models;

use App\Traits\BelongsToUsaha;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use BelongsToUsaha;

    protected $guarded = [];

    public function kategoriMenu(): BelongsTo
    {
        return $this->belongsTo(KategoriMenu::class);
    }

    public function varianMenus(): HasMany
    {
        return $this->hasMany(VarianMenu::class);
    }
}

