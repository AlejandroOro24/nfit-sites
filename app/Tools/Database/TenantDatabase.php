<?php

namespace App\Tools\Database;

use Illuminate\Support\Facades\Http;

class TenantDatabase extends Database
{
    private $website;

    public function setWebsite($website){
        $this->website = $website;
    }

    public function __construct(){
        parent::__construct(null, null, null);
    }

    // public function create()
    // {
    //     $website = $this->website;
        
    //     if(is_callable($website)){
    //         $this->website = $website();
    //     } 

    //     $website = $this->website;

    //     $uuid = $website->uuid;

    //     $app_key = ENV('APP_KEY'); 

    //     $database = $uuid;
    //     $username = $uuid;
    //     $password = md5(sprintf(
    //         '%d.%s.%s.%s',
    //         $website->id,
    //         $website->uuid,
    //         $website->created_at,
    //         $app_key
    //     ));

    //     parent::__construct(
    //         $database,
    //         $username,
    //         $password
    //     );
        
    //     parent::create();
    // }

    // function save()
    // {
    //     $this->create();

    //     $migration = 'database/migrations/tenant';
        
    //     $this->migrate($migration);

    //     $seeder = '\Database\Seeders\Tenant\DatabaseSeeder';
        
    //     $this->seed($seeder);

    //     return true;
    // }

    // function delete()
    // {
    //     parent::delete();
    // }
}