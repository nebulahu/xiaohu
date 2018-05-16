<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function add(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];

        if(!rq('content'))
            return ['status'=>0,'msg'=>'empty content'];

        if(!(rq('question_id') || rq('answer_id')) || (rq('question_id') && rq('answer_id')))
            return ['status'=>0,'question_id or answer_id must hava only one'];
        if(rq('question_id')){
            $question = question_ins()->find(rq('question_id'));
            if(!$question) return ['status'=>0,'msg'=>'question not exists'];
            $this->question_id = rq('question_id');
        }else{
            $answer = answer_ins()->find(rq('answer_id'));
            if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
            $this->answer_id = rq('answer_id');
        }
        if(rq('reply_to')){
            $target = $this->find(rq('reply_to'));
            if(!$target) return ['status'=>0,'msg'=>'target comment not exists'];
            if($target->user_id == session('user_id'))
                return ['status'=>0,'msg'=>'cannot reply to yourself'];
            $this->reply_to = rq('reply_to');
        }
        $this->content = rq('content');
        $this->user_id = session('user_id');

        return $this->save() ?
            ['status'=>1,'id'=>$this->id] :
            ['status'=>0,'msg'=>'数据库插入失败'];
    }

    public function read(){
        if(!(rq('question_id') || rq('answer_id')) || (rq('question_id') && rq('answer_id')))
            return ['status'=>0,'question_id or answer_id must hava only one'];
        if(rq('question_id')){
            $question = question_ins()->with('user')->find(rq('question_id'));
            if(!$question) return ['status'=>0,'msg'=>'question not exists'];
            $data = $this->with('user')->where('question_id',rq('question_id'));
        }else{
            $answer = answer_ins()->with('user')->find(rq('answer_id'));
            if(!$answer) return ['status'=>0,'msg'=>'answer not exists'];
            $data = $this->with('user')->where('answer_id',rq('answer_id'));
        }
        $data = $data->get()->keyBy('id');
        return ['status'=>1,'data'=>$data];
    }

    public function remove(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('id'))
            return ['status'=>0,'msg'=>'id is requeired'];
        $comment = $this->find(rq('id'));
        if(!$comment)
            return ['status'=>0,'msg'=>'comment not exists'];
        if($comment->user_id != session('user_id'))
            return ['status'=>0,'msg'=>'permission denied'];
        $this->where('reply_to',rq('id'))->delete();
        return $comment->delete() ?
            ['status'=>1] :
            ['status'=>0,'msg'=>'db delete failed'];
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
