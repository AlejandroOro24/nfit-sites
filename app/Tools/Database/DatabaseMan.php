<?php
namespace App\Tools\Database;


use App\Models\Website;
use App\Tools\Database\Database; // Asegúrate de importar la clase Database si no lo has hecho ya
use Illuminate\Database\Capsule\Manager as Capsule;


class DatabaseMan
{
    private $database;
    private static $capsule;

    public function __construct() {

    }

    static function initClientDB($client){
        $uuid = $client->database_uuid;
        $website = Website::where('uuid', $uuid)->first();
        
        $app_key = ENV('APP_KEY');
        
        $database = $uuid;
        $username = 'root';
        $password = md5(sprintf(
            '%d.%s.%s.%s',
            $website->id,
            $website->uuid,
            $website->created_at,
            $app_key
        ));

        $config = [
            'driver' => 'mysql',
            'host' => env('DB_HOST'),
            'database' => $database,
            'username' => $username,
            'password' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ];
        $capsule = new Capsule;
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
        
        // $database = new Database($database, $username, $password);

        // return $database;
    }

    public function findTable($client, $tableName) {
        $databaseInstance = self::initClientDB($client);
        
        // Aquí podrías usar el $databaseInstance para ejecutar consultas
        // Supongamos que quieres buscar todas las filas de una tabla específica
        $results = $databaseInstance->table( $tableName);
        
        return $results;
    }


    public static function table($table)
    {
        return self::$capsule->table($table);
    }

    // public static function getTableData($client, $tableName) {
    //     $db = self::initClientDB($client);

    //     $data = $db->table($tableName)->first();
    //     return $data; // Devuelve el objeto directamente
    // }
}