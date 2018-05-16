<div ng-controller="UserController">
    <div class="user card container">
        <h1>用户详情</h1>
        <div class="hr"></div>
        <div class="basic">
            <div class="info-item clearfix">
                <div>username</div>
                <div>[: User.current_user.username :]</div>
            </div>
            <div class="info-item clearfix">
                <div>introduce</div>
                <div>[: User.current_user.intro || '这个人很懒，什么都没有留下' :]</div>
            </div>
        </div>
        <h2>用户提问</h2>
        <div ng-repeat="item in User.his_questions track by $index">
            [: item.title :]
        </div>
        <h2>用户回答</h2>
        <div ng-repeat="item in User.his_answers track by $index" class="feed item clearfix">
            <div class="title">[: item.question.title :]</div>
            [: item.content :]
            <div class="action-set">
                <div class="comment">更新时间[: item.updated_at :]</div>
            </div>
        </div>
    </div>
</div>