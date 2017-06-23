<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Admin\Controllers\QuestionController;
use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Request;


Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


/*API*/
Route::any('api', function(){
    return ['version'=>'v1.0.0'];
});

/*Common API Function*/
function rq($key=null, $default=null){
    return $key ? Request::get($key,$default) : Request::all();
}
function pager($page=1, $limit=10){
    $limit = $limit?:10;
    $skip = ($page?$page-1:0)*$limit;
    return [$limit,$skip];
}
function err($msg=null){
    return ['err'=>1, 'msg'=>$msg];
}
function suc($data=null){
    $ret = ['err'=>0];
    if($data){
        $ret = array_merge($ret, $data);
    }
    return $ret;
}

/*API User*/
// 返回用户实例
function user(){
    return new User();
}
//新用户注册
Route::any('api/signup', function(){
   return user()->signup();
});
//用户登陆
Route::any('api/login', function(){
   return user()->login();
});
//用户退出
Route::any('api/logout', function(){
   return user()->logout();
});
//修改密码
Route::any('api/resetpwd', function(){
   return user()->resetpwd();
});

/*API Question */

//获取 question 模型实例
function question(){
    return new Question();
}
//添加问题
Route::any('api/question/add', function(){
   return question()->add();
});
//编辑问题
Route::any('api/question/edit', function(){
    return question()->edit();
});
//查看问题
Route::any('api/question/read', function(){
    return question()->read();
});
//删除问题
Route::any('api/question/del', function(){
    return question()->del();
});

/*API Answer*/
function answer(){
    return new Answer();
}
//添加回答
Route::any('api/answer/add', function(){
    return answer()->add();
});
//编辑回答
Route::any('api/answer/edit', function(){
    return answer()->edit();
});
//查看回答
Route::any('api/answer/read', function(){
    return answer()->read();
});
//顶踩回答
Route::any('api/answer/vote', function(){
    return answer()->vote();
});


/*API Comment*/
function comment(){
    return new Comment();
}
//添加评论
Route::any('api/comment/add', function(){
    return comment()->add();
});
//查看评论
Route::any('api/comment/read', function(){
    return comment()->read();
});
//删除评论
Route::any('api/comment/del', function(){
    return comment()->del();
});

/*API timeline*/
Route::any('api/timeline', 'CommonController@timeline');


//接口测试
Route::any('api/test', function(){
    dd(user()->islogin());
});