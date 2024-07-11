<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const ADMIN = 1;
    public const COACH = 2;
    /**  User and student are the same. */
    public const USER = 3;
    public const STUDENT = 3;
    public const RECEPTIONIST = 4;
    public const MANAGER = 5;


    public static function humanList()
    {
        return [
            self::ADMIN        => 'administrador',
            self::COACH        => 'entrenador',
            self::USER         => 'alumno',
            self::RECEPTIONIST => 'recepcionista',
            self::MANAGER      => 'manager',
        ];
    }

}
