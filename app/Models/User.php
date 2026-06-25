<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Organization;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['username', 'password', 'role', 'organization_name', 'NIM_NIP', 'ktm', 'id_organization', 'verify_at', 'note',])]
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

    protected $fillable = [
        'name',
        'nim_nip',              // Atau nim_nip, sesuaikan dengan nama kolom asli di database Anda
        'username',
        'email',
        'id_organization',  // Kolom dropdown prodi tadi
        'ktm',
        'password',
        'role',
    ];

    public function inventaris(): HasMany
    {
        return $this->hasMany(Inventaris::class, 'id_user');
    }

    public function surat() : HasMany 
    {
        return $this->hasMany(Surat::class, 'id_user');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'id_organization', 'id');
    }
}
