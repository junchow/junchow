<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategorysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorys')->delete();
        DB::table('categorys')->insert([

            [
                'id'=>100,
                'name'=>'技术',
                'pid'=>0,
                'flag'=>'it',
                'desc'=>'互联网，软件开发',
                'ip'=>'127.0.0.1',
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],

            [
                'id'=>101,
                'name'=>'随笔',
                'pid'=>0,
                'flag'=>'post',
                'desc'=>'网络随笔',
                'ip'=>'127.0.0.1',
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],

            [
                'id'=>102,
                'name'=>'日记',
                'pid'=>0,
                'flag'=>'note',
                'desc'=>'每日一记',
                'ip'=>'127.0.0.1',
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],
        ]);
    }
}
