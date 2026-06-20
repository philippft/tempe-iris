<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table(name: 'categories')]
#[Fillable(['nama'])]
class Category extends Model
{
    use HasFactory;

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class, 'id_category');
    }
}
