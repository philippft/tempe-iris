<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['id_inventaris', 'id_surat', 'qty_inventaris'])]
class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjaman';

    public function inventaris(): BelongsTo
    {
        return $this->belongsTo(Inventaris::class, 'id_inventaris');
    }

    public function surat(): BelongsTo
    {
        return $this->belongsTo(Surat::class, 'id_surat');
    }
}
