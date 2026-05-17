<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama', 'Field'])]
class Category extends Model
{
    protected $table = 'categories';

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class, 'id_category');
    }
}
