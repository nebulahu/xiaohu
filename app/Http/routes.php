<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
function user_ins(){
    return new App\User;
}
function question_ins(){
    return new App\Question;
}
function answer_ins(){
    return new App\Answer;
}
function comment_ins(){
    return new App\Comment;
}
/*绑定传入的参数*/
function rq($key=null,$default=null){
    if(!$key)return Request::all();
    return Request::get($key,$default);
}
/*分页*/
function paginate($page=1,$limit=16){
    $limit = $limit?:16;
    $skip = ($page?($page-1):0)*$limit;
    return [$limit,$skip];
}
function err($msg=null){
    return ['status'=>0,'msg'=>$msg];
}
function suc($data_to_add=[]){
    $data = ['status'=>1,'data'=>[]];
    if($data_to_add)
        $data['data'] = $data_to_add;
    return $data;
}
/*判断用户是否登录*/
function is_logged_in(){
    //dd(session()->all());
    return session('user_id')?:false;
}
Route::get('/', function () {
    return view('index');
});
/*用户api start*/
Route::any('api',function(){
    return ['version'=>'1.0'];
});

Route::any('api/user/signup',function(){
    return user_ins()->signup();
});

Route::any('api/user/login',function(){
    return user_ins()->login();
});

Route::any('api/user/logout',function(){
    return user_ins()->logout();
});

Route::any('api/user/reset_password',function(){
    return user_ins()->reset_password();
});

Route::any('api/user/validate_reset_password',function(){
    return user_ins()->validate_reset_password();
});

Route::any('api/user/change_password',function(){
    return user_ins()->change_password();
});

Route::any('api/user/read',function(){
    return user_ins()->read();
});

Route::any('api/user/exist',function(){
    return user_ins()->exist();
});
/*用户api end*/

/*问题api start*/
Route::any('api/question/add',function(){
    return question_ins()->add();
});

Route::any('api/question/change',function(){
    return question_ins()->change();
});

Route::any('api/question/read',function(){
    return question_ins()->read();
});

Route::any('api/question/remove',function(){
    return question_ins()->remove();
});
/*问题api end*/

/*回答api start*/
Route::any('api/answer/add',function(){
    return answer_ins()->add();
});
Route::any('api/answer/change',function(){
    return answer_ins()->change();
});
Route::any('api/answer/read',function(){
    return answer_ins()->read();
});
Route::any('api/answer/remove',function(){
    return answer_ins()->remove();
});
Route::any('api/answer/vote',function(){
    return answer_ins()->vote();
});
/*回答api end*/
/*评论api start*/
Route::any('api/comment/add',function(){
    return comment_ins()->add();
});
Route::any('api/comment/read',function(){
    return comment_ins()->read();
});
Route::any('api/comment/remove',function(){
    return comment_ins()->remove();
});
/*评论api end*/
/*timeline start*/
Route::any('api/timeline','CommonController@timeline');
/*timeline end*/
Route::any('test',function(){
    dd(user_ins()->is_logged_in());
});
/*页面路由*/
Route::get('tpl/page/home',function(){
    return view('page.home');
});
Route::get('tpl/page/signup',function(){
    return view('page.signup');
});
Route::get('tpl/page/login',function(){
    return view('page.login');
});
Route::get('tpl/page/question_add',function(){
    return view('page.question_add');
});
Route::get('tpl/page/question_detail',function(){
    return view('page.question_detail');
});
Route::get('tpl/page/user',function(){
    return view('page.user');
});