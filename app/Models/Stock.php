<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Table(name: 'stocks')]
#[Fillable(['status'])]
class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    public function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function inventaris(): BelongsTo
    {
        return $this->belongsTo(Inventaris::class, 'id_inventaris');
    }
}
