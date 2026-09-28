<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Shift extends Model {
    protected $guarded = [];
    public function pengguna(): BelongsTo { return $this->belongsTo(User::class, "pengguna_id"); }
}
