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
    /*获取用户信息*/
    public function read(){
        if(!rq('id'))
            return err('id required');
        $get = ['id','username','avatar_url','intro'];
        $user = $this->find(rq('id'),$get);
        $data = $user->toArray();
        $answer_count = answer_ins()->where('user_id',rq('id'))->count();
        $question_count = question_ins()->where('user_id',rq('id'))->count();
        $data['answer_count'] = $answer_count;
        $data['question_count'] = $question_count;
        return suc($data);
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
    /*更改密码*/
    public function change_password(){
        if(!$this->is_logged_in())
            return ['status'=>0,'msg'=>'user is not login'];
        if(!rq('old_password') || !rq('new_password'))
            return ['status'=>0,'msg'=>'old_password and new_password is not required'];
        $user = $this->find(session('user_id'));
        if(!Hash::check(rq('old_password'),$user->password))
            return ['status'=>0,'msg'=>'invalid old_password'];
        $user->password = Hash::make(rq('new_password'));
        return $user->save()?['status'=>1]:['status'=>0,'msg'=>'db change failed'];
    }
    /*找回密码api*/
    public function reset_password(){
        if($this->is_robot())
            return err('max frequency reached');
        if(!rq('phone'))
            return err('phone is required');
        $user = $this->where('phone',rq('phone'))->first();
        if(!$user)
            return err('invalid phone number');
        $captcha = $this->generate_captcha();
        $user->phone_captcha = $captcha;
        if($user->save()){
            $this->send_sms();
            $this->update_robot_time();
            return suc();
        }else{
            return err('db change failed');
        }
    }
    /*验证找回密码api*/
    public function validate_reset_password(){
        if($this->is_robot(2))
            return err('max frequency reached');
        if(!rq('phone') || !rq('phone_captcha') || !rq('new_password'))
            return err('phone , phone captcha and new password is required');
        $user = $this->where(['phone'=>rq('phone'),'phone_captcha'=>rq('phone_captcha')])->first();
        if(!$user)
            return err('invalid phone or invalid phone captcha');
        $user->password = bcrypt(rq('new_password'));
        $this->update_robot_time();
        return $user->save()?suc():err('db change failed');
    }

    public function is_robot($time = 10){
        if(!session('last_action_time'))
            return false;
        $current_time = time();
        $last_action_time = session('last_action_time');
        if($current_time - $last_action_time < $time)
            return true;
        return false;
    }

    public function update_robot_time(){
        session()->set('last_action_time',time());
    }

    /*生成随机数*/
    public function generate_captcha(){
        return rand(1000,9999);
    }

    public function send_sms(){
        return true;
    }

    public function answers(){
        return $this->belongsToMany('App\Answer')->withPivot('vote')->withTimestamps();
    }
}
