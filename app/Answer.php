<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    public function add(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('question_id') || !rq('content'))
            return ['status'=>0,'msg'=>'参数错误'];
        $answered = $this->where(['question_id'=>rq('question_id'),'user_id'=>session('user_id')])->count();
        if($answered)
            return ['status'=>0,'msg'=>'question have been answered'];

        $question = question_ins()->find(rq('question_id'));
        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];
        $this->content = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id = session('user_id');

        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'数据库插入失败'];
    }

    public function change(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('id') || !rq('content'))
            return ['status'=>0,'msg'=>'参数错误'];
        $answer = $this->find(rq('id'));
        if(!$answer)
            return ['status'=>0,'msg'=>'answer not exists'];
        if($answer->user_id != session('user_id'))
            return ['status'=>0,'msg'=>'permission denied'];
        $answer->content = rq('content');
        return $answer->save()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'数据库更新失败'];
    }

    public function read(){
        if(!rq('id') && !rq('question_id'))
            return ['status'=>0,'msg'=>'param error'];
        if(rq('id')){
            $answer = $this->find(rq('id'));
            if(!$answer)
                return ['status'=>0,'msg'=>'answer not exists'];
            return ['status'=>1,'data'=>$answer];
        }
        if(!question_ins()->find(rq('question_id')))
            return ['status'=>0,'msg'=>'question not exists'];
        $answers = $this->where('question_id',rq('question_id'))
            ->get()
            ->keyBy("id");
        return ['status'=>1,'data'=>$answers];
    }
    /*投票api*/
    public function vote(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('id') || !rq('vote'))
            return ['status'=>0,'msg'=>'id and vote is required'];
        $answer = $this->find(rq('id'));
        if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
        $vote = rq('vote') <= 1 ? 1 : 2;
        /*检查相同问题下是否重复投票*/
        $answer->users()->newPivotStatement()->where('user_id',session('user_id'))->where('answer_id',rq('id'))->delete();
        $answer->users()->attach(session('user_id'),['vote' => (int)rq('vote')]);
        return ['status'=>1];
    }

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('vote')->withTimestamps();
    }
}
