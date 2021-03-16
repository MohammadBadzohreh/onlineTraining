<?php

namespace Badzohreh\User\Database\Seeds;

use Badzohreh\User\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Mohammad badzohreh",
            "email" => "badzohreee@gmail.com",
            "username" => "Mohammad badzohreh",
            "mobile" => "09116948828",
            "password" => bcrypt("Mohammad100%"),
            "status" => "active",
            "email_verified_at" => now(),
        ]);
    }
}
