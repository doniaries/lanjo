<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Pesanan extends Model {
    protected $guarded = [];
    public function meja(): BelongsTo { return $this->belongsTo(Meja::class); }
    public function kasir(): BelongsTo { return $this->belongsTo(User::class, "kasir_id"); }
    public function detailPesanans(): HasMany { return $this->hasMany(DetailPesanan::class); }
    public function pembayarans(): HasMany { return $this->hasMany(Pembayaran::class); }
}
