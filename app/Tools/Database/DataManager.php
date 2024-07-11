<?php 
    
    namespace App\Tools\Database;

    use App\Models\Website;


    class DataManager
    {
        private $database;

        public function __construct() {

        }

        static function initClientDB($client){
            $uuid = $client->database_uuid;
            $website = Website::where('uuid', $uuid)->first();
            
            $app_key = ENV('APP_KEY');
            
            $database = $uuid;
            $username = $uuid;
            $password = md5(sprintf(
                '%d.%s.%s.%s',
                $website->id,
                $website->uuid,
                $website->created_at,
                $app_key
            ));

            $database = new Database($database, $username, $password);

            return $database;
        }

        

      
    }