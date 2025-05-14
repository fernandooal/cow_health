<?php

namespace App\Models;

use App\Enums\UserPerfil;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ativo',
        'perfil'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $casts=[
        'perfil' => UserPerfil::class,
    ];

//    public function avisoVigencias()
//    {
//        return $this->belongsToMany(AvisoVigencia::class);
//    }

    protected static function booted() {

        //AssignRole para Criação e SyncRole para Atualização
        static::creating(function ($model) {
            $role = Role::all()->where('name', $model->role)->first();
            $model->assignRole($role);
        });

    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
