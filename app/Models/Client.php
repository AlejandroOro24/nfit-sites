<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tools\Database\Database;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'rut',
        'first_name',
        'last_name',
        'box_name',
        'sub_domain',
        'fqdn',
        'fqdn_api',
        'database_uuid',
        'email',
        'phone',
        'birthdate',
        'avatar',
        'address',
        'lat',
        'lng',
        'status_client',
        'hostname_id',
        'json_sport_center',
        'services',
        'vimeo_folder',
    ];

    public function website()
    {
          return $this->hasOne(Website::class);
    }


//################################################################
    //  CLIENT (BOX DB) CONNECTION
    //################################################################
    public function getBoxDBConnection($uuid)
    {
        $website = $this->website;
        $app_key = ENV('APP_KEY');

        $database = $uuid;
        $username = $uuid;
        $password = md5(
            sprintf(
                '%d.%s.%s.%s',
                $website->id,
                $website->uuid,
                $website->created_at,
                $app_key
            )
        );

        $database = new Database(
            $database,
            $username,
            $password
        );

        $connection = $database->getConnection();

        return $connection;
    }
    //################################################################
    //
    //################################################################
}