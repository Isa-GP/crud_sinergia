<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject; // 👈 Importa esta interfaz
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject // 👈 Implementa JWTSubject
{
    use Notifiable;
    use HasFactory;
        protected $fillable = [
        'name',
        'email',
        'password',
    ];
    // Métodos requeridos por JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Devuelve el ID del usuario
    }

    public function getJWTCustomClaims(): array
    {
        return []; // Puedes agregar claims personalizados si quieres
    }
}
