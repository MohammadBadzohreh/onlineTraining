<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    static $seeders = [];
    public function run()
    {
        foreach (self::$seeders as $seeder){
            $this->call($seeder);
        }
    }
}
