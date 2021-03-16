<?php
namespace Badzohreh\Category\DataBase\Seeds;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{

    public function run()
    {
        \Badzohreh\Category\Models\Category::create([
            "title"=>"وب",
            "slug"=>"web",
        ]);

        \Badzohreh\Category\Models\Category::create([
            "title"=>"php",
            "slug"=>"php",
        ]);
        \Badzohreh\Category\Models\Category::create([
            "title"=>"html",
            "slug"=>"html",
        ]);
    }
}
