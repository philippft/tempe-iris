<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Table(name: 'organizations')]
#[Fillable(['nama'])]
class Organization extends Model
{
    //
    use HasFactory;
}
