<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->delete();
        DB::table('options')->insert([
            [
                'id'=>100,
                'title'=>'站点名称',
                'name'=>'sitename',
                'value'=>'JunChow',
                'status'=>'base',
                'type'=>'text',
                'group'=>'',
                'remark'=>'',
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],
            [
                'id'=>101,
                'title'=>'站点关键词',
                'name'=>'keywords',
                'value'=>'JunChow',
                'status'=>'base',
                'type'=>'textarea',
                'group'=>'',
                'remark'=>'',
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],
            [
                'id'=>102,
                'title'=>'站点描述',
                'name'=>'description',
                'value'=>'JunChow',
                'status'=>'base',
                'type'=>'textarea',
                'group'=>'',
                'remark'=>'',
                'created_at'=>'2017-06-20 02:30:10',
                'updated_at'=>'2017-06-20 02:30:10',
            ],
        ]);
    }
}
