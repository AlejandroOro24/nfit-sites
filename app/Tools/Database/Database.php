<?php

namespace App\Tools\Database;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class Database
{
    private $connection;
    private $connection_values;
    private $connection_path;

    private function setConnectionValues(){
        $this->connection = 'conectado';
        $this->connection_values = [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => '',
            'username' => '',
            'password' => '',
        ];
        $this->connection_path = 'database.connections';
    }

    function __construct($database, $username, $password)
    {
        $this->setConnectionValues();

        $this->connection_path .= '.' . $this->connection;
        $this->connection_values['database'] = $database;
        $this->connection_values['username'] = 'root';
        $this->connection_values['password'] = '';
        $this->initConnection();
    }

    function initConnection()
    {
        DB::purge(
            $this->connection
        );
        
        Config::set(
            $this->connection_path,
            $this->connection_values
        );
    }
    
    function getConnection()
    {
        return $this->connection;
    }
}