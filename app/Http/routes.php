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

Route::get('/', function () {
    return view('welcome');
});
/*用户api start*/
Route::any('api',function(){
    return ['version'=>'1.0'];
});

Route::any('api/signup',function(){
    return user_ins()->signup();
});

Route::any('api/login',function(){
    return user_ins()->login();
});

Route::any('api/logout',function(){
    return user_ins()->logout();
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
Route::any('test',function(){
    dd(user_ins()->is_logged_in());
});