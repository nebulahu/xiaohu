<div ng-controller="SignupController" class="signup container">
    <div class="card">
        <h1>注册</h1>
        <form name="signup_form" ng-submit="User.signup()">
            {{--[: User.signup_data :]--}}
            <div class="input-group">
                <label for="username">用户名</label>
                <input name="username" type="text" ng-model="User.signup_data.username" ng-minlength="2" ng-maxlength="12" ng-model-options="{debounce:500}" required >
                <div class="input-error-set" ng-if="signup_form.username.$touched">
                    <div ng-if="signup_form.username.$error.required">用户名必填</div>
                    <div ng-if="signup_form.username.$error.maxlength || signup_form.username.$error.minlength">用户名在2~12位之内</div>
                    <div ng-if="User.signup_username_exists">用户名已存在</div>
                </div>
            </div>
            <div class="input-group">
                <label for="password">密码</label>
                <input name="password" type="password" ng-model="User.signup_data.password" ng-minlength="6" ng-maxlength="32" required>
                <div class="input-error-set" ng-if="signup_form.password.$touched">
                    <div ng-if="signup_form.password.$error.required">密码必填</div>
                    <div ng-if="signup_form.password.$error.maxlength || signup_form.password.$error.minlength">密码长度在6~32位之内</div>
                </div>
            </div>
            <button class="primary" type="submit" ng-disabled="signup_form.$invalid">注册</button>
        </form>
    </div>
</div>