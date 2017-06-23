<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        factory('App\Models\User',10)->create()->each(function($u){
            //$u->posts()->save(factory('App\Models\Post')->make());
        });
    }
}
