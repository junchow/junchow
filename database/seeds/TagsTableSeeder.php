<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->delete();
        DB::table('tags')->insert([
            [
                'id'=>100,
                'name'=>'技术',
                'flag'=>'it',
                'count'=>1,
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],
        ]);
    }
}
