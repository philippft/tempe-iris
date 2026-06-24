<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(name: 'kegiatans')]
#[Fillable(['id_surat', 'nama', 'hari_mulai', 'tanggal_mulai', 'waktu_mulai', 'waktu_selesai'])]
class Kegiatan extends Model
{

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
        ];
    }

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
