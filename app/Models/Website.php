<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Tools\Database\Database;

class Website extends Model
{
    use HasFactory;
    
    private $database = null;
    
    //################################################################
    //  INICIAR CONEXIÓN BASE DE DATOS TENANT (BOX CLIENTE)
    //################################################################
    protected static function booting()
    {
        static::retrieved(function($website) {
            $website->initDatabase();
        });
    }
   
    //################################################################
    //  BASE DE DATOS (INICIALIZACIÓN)
    //################################################################
    public function initDatabase(){
        $app_key = ENV('APP_KEY');
        
        $database = $this->uuid;
        $username = $this->uuid;
        $password = md5(sprintf(
            '%d.%s.%s.%s',
            $this->id,
            $this->uuid,
            $this->created_at,
            $app_key
        ));
        
        $database = new Database(
            $database,
            $username, 
            $password
        );

        $this->database = $database;
    }

    public function getDatabase(){
        return $this->database;
    }
    //################################################################
    //  RELATIONSHIPS
    //################################################################
    public function hostnames()
    {
        return $this->HasMany(Website::class);
    }

    // public function client(): HasOneThrough
    // {
    //     return $this->hasOneThrough(Client::class, Hostname::class);
    // }
    //################################################################
    //
    //################################################################
}