<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Request;
use Hash;
class User extends Model
{
    //sign
    public function signup(){
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password)
            return ['status'=>0,'msg'=>'用户名和密码不能为空'];
        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];
        /*检查用户名是否存在*/
        $user_exists = $this->where('username',$username)->exists();
        if($user_exists)
            return ['status'=>0,'msg'=>'用户名已存在'];
        /*密码加密*/
        $hash_password = Hash::make($password);
        //dd($hash_password);
        /*存入数据库*/
        $user = $this;
        $user->username = $username;
        $user->password = $hash_password;
        if($user->save())
            return ['status'=>1,'id'=>$user->id];
        else
            return ['status'=>1,'msg'=>'db insert failed'];
    }

    /*login*/
    public function login(){
        $has_username_and_password = $this->has_username_and_password();
        if(!$has_username_and_password)
            return ['status'=>0,'msg'=>'用户名和密码不能为空'];
        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];
        /*检测用户是否存在*/
        $user = $this->where('username',$username)->first();
        if(!$user)
            return ['status'=>0,'msg'=>'用户不存在'];
        /*检测密码是否正确*/
        $hash_password = $user->password;
        if(!Hash::check($password,$hash_password))
            return ['status'=>0,'msg'=>'密码错误'];
        /*将用户信息写入session*/
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);
        //dd(session()->all());
        return ['status'=>1,'id'=>$user->id];
    }
    /*登出api*/
    public function logout(){
        /*清除session*/
        //session->flush();
        //session()->put('username',null);
        //session()->put('user_id',null);
        session()->forget('username');
        session()->forget('user_id');
        //dd(session()->all());
        return ['status' => 1];
        //return  redirect('/');
    }

    public function has_username_and_password(){
        $username = rq('username');
        $password = rq('password');
        /*检查用户名是否为空*/
        /*检查密码是否为空*/
        if($username && $password)
            return [$username,$password];
        return false;
    }
    /*判断用户是否登录*/
    public function is_logged_in(){
        //dd(session()->all());
        return session('user_id')?:false;
    }

    public function answers(){
        return $this->belongsToMany('App\Answer')->withPivot('vote')->withTimestamps();
    }
}
