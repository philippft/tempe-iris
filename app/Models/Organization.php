<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table(name: 'organizations')]
#[Fillable(['name'])]
class Organization extends Model
{
    //
    use HasFactory;

    public function casts(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_organization');
    }
}
