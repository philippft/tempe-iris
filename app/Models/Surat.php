<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'id_user', 'nomor', 'status_peminjaman', 'catatan_peminjaman', 
    'perihal_peminjaman', 'tanggal_peminjaman', 'tanggal_kembali', 
    'tandatangan_pimpinan', 'penyelenggara', 'acara', 'prodi', 
    'nama_peminjam', 'nim', 'nama_kegiatan'
])]

#[Table(name: 'surat')]
class Surat extends Model
{

    protected function casts(): array
    {
        return [
            'status_peminjaman' => 'boolean',
            'tandatangan_pimpinan' => 'boolean',
            'tanggal_peminjaman' => 'datetime',
            'tanggal_kembali' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_surat');
    }

    public function kegiatan(): HasMany
    {
        return $this->hasMany(Kegiatan::class, 'id_surat');
    }
}
