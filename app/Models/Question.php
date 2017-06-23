<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //API

    //API 添加问题
    public function add()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }
        $this->user_id = session('user_id');
        //判断标题是否传入（必选）
        if(!rq('title')){
            return ['err'=>1, 'msg'=>'标题不存在'];
        }
        $this->title = rq('title');
        //判断描述是否传入（可选）
        if(rq('description')){
            $this->description = rq('description');
        }

        return $this->save() ? ['err'=>0, 'msg'=>'添加成功','id'=>$this->id] : ['err'=>1,'添加失败'];
    }
    // API 编辑问题
    public function edit()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }
        //判断问题编号
        if(!rq('id')){
            return ['err'=>1,'msg'=>'参数错误'];
        }
        //仅发布人可修改
        $question = $this->find(rq('id'));
        if(!$question){
            return ['err'=>1,'msg'=>'问题不存在'];
        }
        //仅发布人可修改
        if($question['user_id'] != session('user_id')){
            return ['err'=>1, 'msg'=>'仅发布人可编辑'];
        }
        //获取更新字段
        if(rq('title')){
            $question->title = rq('title');
        }
        if(rq('description')){
            $question->description = rq('description');
        }
        //数据库更新
        return $question->save()?['err'=>0,'msg'=>'编辑成功']:['err'=>1,'编辑失败'];
    }
    //API 查看问题
    public function read()
    {
        //指定ID查询
        if(rq('id')){
            return ['err'=>0,'data'=>$this->find(rq('id'))];
        }

        //默认查看多条
//      $limit = rq('limit') ? : 3;// 每页条数
//      $skip = (rq('page')?rq('page')-1:0) * $limit;// 页码求位移

        list($limit,$skip) = pager(rq('page'),rq('limit'));
        $field = ['id','title','description','created_at'];
        $data = $this->orderBy('created_at')->limit($limit)->skip($skip)->get($field)->keyBy('id');

        //返回 collection 数据
        return $data ? ['err'=>0, 'data'=>$data] : ['err'=>1,'暂无数据'];
    }
    //API 删除问题
    public function del()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }
        //判断问题编号是否存在
        if(!rq('id')){
            return ['err'=>1, 'msg'=>'参数错误'];
        }
        //判断问题是否存在
        $question = $this->find(rq('id'));
        if(!$question){
            return ['err'=>1, 'msg'=>'数据不存在'];
        }
        //发布者可删除，审核人可删除（未实现）
        if(session('user_id') != $question['user_id']){
            return ['err'=>1, 'msg'=>'权限不足'];
        }

        //返回数据
        return $question->delete() ? ['err'=>0,'msg'=>'删除成功'] : ['err'=>1,'msg'=>'删除失败'];
    }
}
