<?php
namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class User extends Authenticatable
{
    use Notifiable;

    public $table = 'users';

    protected $fillable = [
      'username','password','email'
    ];

    protected $hidden = [
      'password','remember_token'
    ];

    public static $aliases = [
        'username'=>'账户',
        'password'=>'密码',
        'email'=>'邮箱',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class,'id', 'user_id');
    }

    public function article(){
        //return $this->hasMany(Article::class, 'id', 'user_id');
    }




    /*api common : 检测账户和密码*/
    public function has_username_password()
    {
        //接收请求参数并检查账户和密码是否同时存在
        $username = Request::get('username');
        $password = Request::get('password');
        return $username&&$password ? ['username'=>$username, 'password'=>$password] : false;
    }
    /*api 用户注册*/
    public function signup()
    {
        //判断参数
        $user = $this->has_username_password();
        if(!$user){
            return ['err'=>1, 'msg'=>'账户或密码为空'];
        }
        //密码加密
        $this->password = bcrypt($user['password']);//bcrypt()是 Hash::make() 的快捷写法
        $this->username = $user['username'];
        // 插入数据并返回
        return $this->save() ? ['err'=>0, 'id'=>$this->id] : ['err'=>1, 'msg'=>'注册失败'];
    }

    /*api 用户登陆*/
    public function login()
    {
        //参数判断
        $user = $this->has_username_password();
        if(!$user){
            return ['err'=>1, 'msg'=>'账户或密码为空'];
        }

        //检查账户是否存在
        $dbuser = $this->where('username',$user['username'])->first();//获取唯一一条
        if(!$dbuser){
            return ['err'=>1, 'msg'=>'账户不存在'];
        }

        //检查密码
        if(!Hash::check($user['password'], $dbuser['password'])){
            return ['err'=>1, 'msg'=>'密码错误'];
        }

        //回话记录
        session()->put('user_id', $dbuser->id);
        session()->put('username', $dbuser->username);

        //dd(session()->all());
        return ['err'=>0, 'id'=>$dbuser->id];
    }
    /*api 用户退出*/
    public function logout()
    {
        session()->forget('user_id');
        session()->forget('username');

        return ['err'=>0, 'msg'=>'安全退出'];
    }
    /*api common: 判断用户是否登陆*/
    public function islogin()
    {
        return session('user_id') ? : false;
    }
    /*api  修改密码*/
    public function resetpwd()
    {
        //判断是否登录
        if(!$this->islogin()){
            return ['err'=>1, 'msg'=>'尚未登录'];
        }

        //判断新旧密码
        if(!rq('oldpwd') || !rq('newpwd')){
            return ['err'=>1, 'msg'=>'缺少新旧密码'];
        }

        //判断旧密码
        $user = $this->find(session('user_id'));
        if(!Hash::check(rq('oldpwd'), $user->password)){
            return ['err'=>1, 'msg'=>'旧密码错误'];
        }

        //更新密码
        $user->password = bcrypt(rq('newpwd'));
        return $user->save() ? ['err'=>0,'msg'=>'设置成功'] : ['err'=>0,'msg'=>'设置失败'];
    }

    /*关联关系*/
    public function answer()
    {
        return $this->belongsToMany(Answer::class)->withPivot('vote')->withTimestamps();
    }
}