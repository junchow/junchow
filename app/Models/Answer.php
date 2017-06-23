<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Answer extends Model
{



    /*API 添加回答*/
    public function add()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }
        $this->user_id = session('user_id');

        //判断问题和回答
        if(!rq('question_id') || !rq('content')){
            return ['err'=>1, 'msg'=>'缺少问题编号和回答内容'];
        }

        //判断问题是否存在
        $question = question()->find(rq('question_id'));
        if(!$question){
            return ['err'=>1, 'msg'=>'问题不存在'];
        }
        $this->question_id = $question->id;

        //同一问题仅作答一次
        $count = $this->where(['question_id'=>rq('question_id'), 'user_id'=>session('user_id')])->count();
        if($count){
            return ['err'=>1, 'msg'=>'已回答过'];
        }

        //数据库添加
        $this->content=rq('content');
        return $this->save() ? ['err'=>0,'msg'=>'回答成功','id'=>$this->id] : ['err'=>0,'msg'=>'回答失败'];

    }
    /*API 编辑回答*/
    public function edit()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }

        //判断回答编号是否存在
        if(!rq('id') || !rq('content')){
            return ['err'=>1, 'msg'=>'缺少回答编号和回答内容'];
        }

        //判断回答是否存在
        $answer = $this->find(rq('id'));
        if(!$answer){
            return ['err'=>1, 'msg'=>'回答不存在'];
        }

        //作答人可编辑
        if($answer['user_id'] != session('user_id')){
            return ['err'=>1, 'msg'=>'权限不足'];
        }

        //数据库更新
        $answer->content=rq('content');

        return $answer->save() ? ['err'=>0,'msg'=>'编辑成功'] : ['err'=>0,'msg'=>'编辑失败'];

    }
    /*API 查看回答*/
    public function read()
    {
        if(!rq('id') && !rq('question_id')){
            return ['err'=>1, 'msg'=>'缺少回答编号或问题编号'];
        }

        //查看单条回答
        if(rq('id')){
            $answer = $this->find(rq('id'));
            if(!$answer){
                return ['err'=>1,'msg'=>'回答不存在'];
            }
            return ['err'=>0,'data'=>$answer];
        }

        //判断问题是否存在
        $question = question()->find(rq('question_id'));
        if(!$question){
            return ['err'=>1, 'msg'=>'问题不存在'];
        }

        //查看指定问题下的回答
        $answers = $this->where('question_id',rq('question_id'))->get()->keyBy('id');
        return ['err'=>0,'data'=>$answers];
    }

    /*关联关系*/
    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot('vote')->withTimestamps();
    }
    /*API 用户投票*/
    public function vote()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }

        //判断回答编号和投票是否存在
        if(!rq('id')){
            return ['err'=>1, 'msg'=>'缺少回答编号'];
        }
        if(!Request::has('vote')){
            return ['err'=>1, 'msg'=>'缺少投票'];
        }

        //判断投票类型
        $vote = rq('vote') ? 1 : 0;//1顶0踩

        //判断问题是否存在
        $answer = $this->find(rq('id'));
        if(!$answer){
            return ['err'=>1, 'msg'=>'回答不存在'];
        }

        //判断用户在相同回答下是否已投票，注意 answer_user 中 answer_id+user_id+vote 必须唯一，即一个用户对一个问题只能投一票。
        //获取中间表
        $answer_user = $answer->user()->newPivotStatement();
        //删除投票记录
        $answer_user->where(['answer_id'=>rq('id'), 'user_id'=>session('user_id')])->delete();
        //添加投票
        $answer->user()->attach(session('user_id'), ['vote'=>$vote]);

        return ['err'=>0,'msg'=>'投票成功'];

    }
}
