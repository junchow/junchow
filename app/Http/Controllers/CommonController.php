<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    /*API 时间线*/
    public function timeline()
    {
        list($limit,$skip) = pager(rq('page'), rq('limit'));

        //获取所有问题和回答
        $questions = question()->limit($limit)->skip($skip)->orderBy('created_at', 'DESC')->get();
        $answers = answer()->limit($limit)->skip($skip)->orderBy('created_at', 'DESC')->get();

        //合并数据后按时间降序排列
        $data = $questions->merge($answers);
        $data->sortByDesc(function($item){
           return $item->created_at;
        });

        //去除默认的 key
        $data  = $data->values()->all();

        return $data;
    }
}
