<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public function add(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('title'))
            return ['status'=>0,'msg'=>'没有标题'];
        $this->title = rq('title');
        $this->user_id = session('user_id');

        if(rq('desc'))
            $this->desc = rq('desc');
        return $this->save()?
            ['status'=>1,'id'=>$this->id]:
            ['status'=>0,'msg'=>'数据库插入失败'];
    }

    public function change(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('id'))
            return ['status'=>0,'msg'=>'参数错误'];
        $question = $this->find(rq('id'));
        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];
        if($question->user_id != session('user_id'))
            return ['status'=>0,'msg'=>'permission denied'];
        if(rq('title'))
            $question->title = rq('title');
        if(rq('desc'))
            $question->desc = rq('desc');
        return $question->save()?
            ['status'=>1,'id'=>$question->id]:
            ['status'=>0,'msg'=>'数据库更新失败'];
    }

    public function read(){
        if(rq('id'))
            return ['status'=>1,'data'=>$this->find(rq('id'))];
        $limit = rq('limit')?:2;
        $skip = (rq('page')?rq('page')-1:0)*$limit;
        list($limit,$skip) = paginate(rq('page'),rq('limit'));
        $list = $this->orderBy('created_at')
                ->limit($limit)
                ->skip($skip)
                ->get(['id','title','desc','user_id','created_at'])
                ->keyBy("id");
        return ['status'=>1,'data'=>$list];
    }

    public function remove(){
        if(!user_ins()->is_logged_in())
            return ['status'=>0,'msg'=>'用户未登录'];
        if(!rq('id'))
            return ['status'=>0,'msg'=>'参数错误'];
        $question = $this->find(rq('id'));
        if(!$question)
            return ['status'=>0,'msg'=>'question not exists'];
        if($question->user_id != session('user_id'))
            return ['status'=>0,'msg'=>'permission denied'];
        return $question->delete()?
            ['status'=>1]:
            ['status'=>0,'msg'=>'数据库删除失败'];
    }

    public function users(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
