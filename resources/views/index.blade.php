<!doctype html>
<html ng-controller="BaseController" lang="zh" ng-app="xiaohu" user_id="{{session('user_id')}}">
<head>
    <meta charset="uef-8" />
    <title>知乎</title>
    <link rel="stylesheet" href="/node_modules/normalize-css/normalize.css" />
    <link rel="stylesheet" href="css/base.css" />
    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <script src="/node_modules/angular/angular.js"></script>
    <script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="/js/base.js"></script>
    <script src="/js/common.js"></script>
    <script src="/js/question.js"></script>
    <script src="/js/user.js"></script>
    <script src="/js/answer.js"></script>
</head>
<body>
<div class="navbar clearfix">
    <div class="container clearfix">
        <div class="fl">
            <div ui-sref="home" class="navbar-item brand">知乎</div>
            <form ng-submit="Question.go_add_question()" id="quick_ask" ng-controller="QuestionAddController">
                <div class="navbar-item">
                    <input ng-model="Question.new_question.title" type="text">
                </div>
                <div class="navbar-item">
                    <button>提问</button>
                </div>
            </form>
        </div>
        <div class="fr">
            <a ui-sref="home" class="navbar-item">首页</a>
            @if(is_logged_in())
            <a ui-sref="" class="navbar-item">{{session('username')}}</a>
            <a href="{{url('/api/user/logout')}}" class="navbar-item">登出</a>
            @else
            <a ui-sref="login" class="navbar-item">登录</a>
            <a ui-sref="signup" class="navbar-item">注册</a>
            @endif
        </div>
    </div>
</div>
<div class="page">
    <div ui-view></div>
</div>
<script type="text/ng-template" id="comment.tpl">
<div class="comment-block clearfix">
    <div class="hr"></div>
    <div class="comment-item-set">
        {{--<div class="rect"></div>--}}
        <div ng-if="!helper.obj_length(data)" class="gray tac well">
            暂无评论
        </div>
        <div ng-if="helper.obj_length(data)" ng-repeat="item in data track by $index" class="comment-item clearfix">
            <div class="user fl">[: item.user.username :]:</div>
            <div class="comment-content fr">
                [: item.content :]
            </div>
        </div>
    </div>
    <div class="input-group">
        <form ng-submit="_.add_comment()" class="comment-form" name="comment-form">
            <input type="text" name="content" ng-model="Answer.new_comment.content" placeholder="说些什么..." required>
            <button ng-disabled="comment-form.$invalid" type="submit" class="primary">评论</button>
        </form>
    </div>
</div>
</script>
</body>
</html>