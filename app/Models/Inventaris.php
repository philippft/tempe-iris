<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table(name: 'inventaris')]
#[Fillable(['id_user', 'id_category', 'nama', 'deskripsi', 'image'])]
class Inventaris extends Model
{
    public function casts(): array
    {
        return [
            'id_user' => 'integer',
            'id_category' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_inventaris');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'id_inventaris');
    }
}
