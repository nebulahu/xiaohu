<!doctype html>
<html lang="zh" ng-app="xiaohu">
<head>
    <meta charset="uef-8" />
    <title>知乎</title>
    <link rel="stylesheet" href="/node_modules/normalize-css/normalize.css" />
    <link rel="stylesheet" href="css/base.css" />
    <script src="/node_modules/jquery/dist/jquery.js"></script>
    <script src="/node_modules/angular/angular.js"></script>
    <script src="/node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="/js/base.js"></script>
</head>
<body>
<div class="navbar clearfix">
    <div class="container">
        <div class="fl">
            <div class="navbar-item brand">知乎</div>
            <div class="navbar-item">
                <input type="text">
            </div>
        </div>
        <div class="fr">
            <a ui-sref="home" class="navbar-item">首页</a>
            <a ui-sref="login" class="navbar-item">登录</a>
            <a ui-sref="signup" class="navbar-item">注册</a>
        </div>
    </div>
</div>
<div class="page">
    <div ui-view></div>
</div>
</body>
<script type="text/ng-template" id="home.tpl">
<div class="home container">
    <h1>首页</h1>
    gfdlkajglkfjd gpigkpjafdgkljalf gjljgalkfdjglkadfjghyoi
</div>
</script>
<script type="text/ng-template" id="signup.tpl">
<div ng-controller="SignupController" class="signup container">
    <div class="card">
        <h1>注册</h1>
        <form name="signup_form" ng-submit="User.signup()">
            [: User.signup_data :]
            <div>
                <label for="username">用户名</label>
                <input name="username" type="text" ng-model="User.signup_data.username" ng-minlength="4" ng-maxlength="24" required >
                <div class="input-error-set">
                    <div ng-if="signup_form.username.$error.required">用户名必填</div>
                </div>
            </div>
            <div>
                <label for="password">密码</label>
                <input name="password" type="password" ng-model="User.signup_data.password" ng-minlength="6" ng-maxlength="255" required>
            </div>
            <button type="submit" ng-disabled="signup_form.$invalid">注册</button>
        </form>
    </div>
</div>
</script>
<script type="text/ng-template" id="login.tpl">
<div class="login container">
    <h1>登录</h1>
</div>
</script>
</html>