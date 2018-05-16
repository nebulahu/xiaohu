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

    public function remove(){
        if(!user_ins()->is_logged_in())
            return err('login required');
        if(!rq('id'))
            return err('id is requeired');
        $answer = $this->find(rq('id'));
        if(!$answer)
            return err('answer not exists');
        if($answer->user_id != session('user_id'))
            return err('permission denied');
        return $answer->delete() ?
            suc() : err('db delete failed');
    }

    public function read_by_user_id($user_id){
        $user = user_ins()->find($user_id);
        if(!$user)
            return err('用户不存在');
        return suc($this->with('question')->where('user_id',$user_id)->get()->keyBy("id")->toArray());
    }

    public function read(){
        if(!rq('id') && !rq('question_id') && !rq('user_id'))
            return ['status'=>0,'msg'=>'param error'];
        if(rq('user_id')){
            $user_id = rq('user_id') === 'self'?session('user_id'):rq('user_id');
            return $this->read_by_user_id($user_id);
        }

        if(rq('id')){
            $answer = $this->with('user')->with('users')->find(rq('id'));
            if(!$answer)
                return ['status'=>0,'msg'=>'answer not exists'];
            $answer = $this->count_vote($answer);
            return ['status'=>1,'data'=>$answer];
        }
        if(!question_ins()->find(rq('question_id')))
            return ['status'=>0,'msg'=>'question not exists'];
        $answers = $this->where('question_id',rq('question_id'))
            ->get()
            ->keyBy("id");
        return ['status'=>1,'data'=>$answers];
    }

    public function count_vote($answer){
        $upvote_count = 0;
        $downvote_count = 0;
        foreach($answer->users as $user){
            if($user->pivot->vote == 1)
                $upvote_count++;
            else
                $downvote_count++;
        }
        $answer->upvote_count = $upvote_count;
        $answer->downvote_count = $downvote_count;
        return $answer;
    }

    /*投票api*/
    public function vote(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'login required'];
        if(!rq('id') || !rq('vote'))
            return ['status'=>0,'msg'=>'id and vote is required'];
        $answer = $this->find(rq('id'));
        if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
        $vote = rq('vote');
        if($vote != 1 && $vote !=2 && $vote !=3)
            return ['status'=>0,'msg'=>'param error'];
        /*检查相同问题下是否重复投票*/
        $answer->users()->newPivotStatement()->where(['user_id'=>session('user_id'),'answer_id'=>rq('id')])->delete();
        if($vote == 3)
            return ['status'=>1];
        $answer->users()->attach(session('user_id'),['vote' => (int)rq('vote')]);
        return ['status'=>1];
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public function users(){
        return $this->belongsToMany('App\User','answer_user','answer_id','user_id')->withPivot('vote')->withTimestamps();
    }

    public function question(){
        return $this->belongsTo('App\Question', 'question_id', 'id');
    }
}
