<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusUser extends Model
{
    use HasFactory;

    
    /**  Satus User  */
    public const ACTIVO = 1;
    public const ACTIVE = 1;

    /**  Satus User  */
    public const INACTIVO = 2;
    public const INACTIVE = 2;

    /**  Satus User  */
    public const PRUEBA = 3;
    public const TEST = 3;

    /**
     *  [$type description]
     *
     *  @var [type]
     */
    protected $type = [
        0 => 'secondary',
        1 => 'success',
        2 => 'danger',
        3 => 'warning'
    ];

    protected $typeName = [
        0 => 'SIN ESTADO',
        1 => 'ACTIVO',
        2 => 'INACTIVO',
        3 => 'PRUEBA'
    ];


     /**
     *  Return a User Status by an specific Id
     *
     *  @param   integer   Id for a status
     *
     *  @return  string    A User Status
     */
    public function getUserColor($planStatusId)
    {
        $users_colors = $this->listUserColors();

        return $users_colors[$planStatusId] ?? 'secondary';
    }

      /**
     *  List all avaiable statuses for a specific User
     *
     *  @return  array
     */
    public function listUserColors()
    {
        return [
            self::ACTIVO => 'success',
            self::INACTIVO => 'danger',
            self::PRUEBA => 'warning',
        ];
    }

}
