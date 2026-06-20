<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 

#[Fillable(['username', 'password', 'role', 'organization_name', 'NIM_NIP'])]
#[Hidden(['password', 'remember_token'])]
#[Table(name: 'users')]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class, 'id_user');
    }

    public function surat() : HasMany 
    {
        return $this->hasMany(Surat::class, 'id_user');
    }
}
