<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /*API 添加评论*/
    public function add()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }
        $this->user_id = session('user_id');

        //判断评论内容
        if(!rq('content')){
            return ['err'=>1, 'msg'=>'缺少评论内容'];
        }
        $this->content = rq('content');

        //针对问题或回答评论
        if(!rq('question_id') && !rq('answer_id')){
            return ['err'=>1, 'msg'=>'缺少问题编号或回答编号'];
        }
        if(rq('question_id') && rq('answer_id')){
            return ['err'=>1, 'msg'=>'禁止同时评论问题和回答'];
        }

        //针对问题评论
        if(rq('question_id')){
            //判断问题是否存在
            $question = question()->find(rq('question_id'));
            if(!$question){
                return ['err'=>1,'msg'=>'问题不存在'];
            }
            $this->question_id = rq('question_id');
        }

        //针对回答评论
        if(rq('answer_id')){
            //判断回答是否存在
            $answer = answer()->find(rq('answer_id'));
            if(!$answer){
                return ['err'=>1, 'msg'=>'回答不存在'];
            }
            $this->answer_id = rq('answer_id');
        }

        //针对评论而评论
        if(rq('reply_id')){
            //判断评论是否存在
            $comment = $this->find(rq('reply_id'));
            if(!$comment){
                return ['err'=>1, 'msg'=>'评论不存在'];
            }

            //禁止对自己评论进行评论
            if($comment->user_id == session('user_id')){
                return ['err'=>1, 'msg'=>'禁止自身评论'];
            }

            $this->reply_id = rq('reply_id');
        }


        //保存数据
        return $this->save()?['err'=>0,'msg'=>'评论成功','id'=>$this->id]:['err'=>1,'msg'=>'评论失败'];
    }

    /*API 查看评论*/
    public function read()
    {
        //判断参数
        if(!rq('question_id') && !rq('answer_id')){
            return ['err'=>1, 'msg'=>'缺少问题编号或回答编号'];
        }

        //查看问题的评论
        if(rq('question_id')){
            //判断问题是否存在
           $question = question()->find(rq('question_id'));
           if(!$question){
               return ['err'=>1, 'msg'=>'问题不存在'];
           }
            //获取问题下所有评论
           $comment = $this->where('question_id',rq('question_id'));
        }

        //查看回答下的评论
        if(rq('answer_id')){
            //判断回答是否存在
            $answer = answer()->find(rq('answer_id'));
            if(!$answer){
                return ['err'=>1, 'msg'=>'回答不存在'];
            }
            //获取回答下所有评论
            $comment = $this->where('answer_id', rq('answer_id'));
        }

        $data = $comment->get()->keyBy('id');
        //返回评论
        return $data->isEmpty() ? ['err'=>1, 'msg'=>'暂无评论'] : ['err'=>0, 'data'=>$data];
    }
    /*API 删除评论*/
    public function del()
    {
        //判断用户是否登录
        if(!user()->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }

        //判断评论编号
        if(!rq('id')){
            return ['err'=>1, 'msg'=>'缺少评论编号'];
        }

        //判断评论是否存在
        $comment = $this->find(rq('id'));
        if(!$comment){
            return ['err'=>1, 'msg'=>'评论不存在'];
        }

        //自身可删除
        if($comment->user_id != session('user_id')){
            return ['err'=>1, 'msg'=>'权限不足'];
        }

        //删除评论下的回复
        $this->where('reply_id',rq('id'))->delete();

        //删除评论
        return $comment->delete()?['err'=>0,'msg'=>'删除成功']:['err'=>1,'msg'=>'删除失败'];
    }
}
