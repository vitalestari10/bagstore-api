<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TransaksiDetail; // ✅ Tambahkan ini
use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['kode', 'user_id', 'tanggal', 'total'];

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
