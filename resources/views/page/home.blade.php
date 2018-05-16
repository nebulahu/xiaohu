<div ng-controller="HomeController" class="home card container">
    <h1>最新动态</h1>
    <div class="hr"></div>
    <div classs="item-set">
        <div ng-repeat="item in Timeline.data track by $index" class="feed item clearfix">
            <div ng-if="item.question_id" class="vote tac">
                <div ng-click="Timeline.vote({id:item.id,vote:1})" class="up">赞[: item.upvote_count :]</div>
                <div ng-click="Timeline.vote({id:item.id,vote:2})" class="down">踩[: item.downvote_count :]</div>
            </div>
            <div class="feed-item-content">
                <div ng-if="item.question_id" class="content-act"><span ui-sref="user({id:item.user.id})">[: item.user.username :]</span>添加了回答</div>
                <div ng-if="item.question_id" class="title"><span ui-sref="question.detail({id:item.question.id})">[: item.question.title :]</span></div>
                <div ng-if="!item.question_id" class="content-act"><span ui-sref="user({id:item.user.id})">[: item.user.username :]</span>添加了提问</div>
                <div class="title"><span ui-sref="question.detail({id:item.id})">[: item.title :]</span></div>
                <div class="content-owner"><span ui-sref="user({id:item.user.id})">[: item.user.username :]</span>
                    <span class="desc">[: item.user.intro || '这个家伙很懒，什么都没有留下' :]</span>
                </div>
                <div ng-if="item.question_id" class="content-main">
                    [: item.content :]
                    <div class="gray"><span ui-sref="question.detail({id:item.question_id,answer_id:item.id})">[: item.updated_at :]</span></div>
                </div>
                <div ng-if="!item.question_id" class="content-main">
                    [: item.desc :]
                    <div class="gray"><span ui-sref="question.detail({id:item.id})">[: item.updated_at :]</span></div>
                </div>
                <div class="action-set">
                    <span ng-click="item.show_comment = !item.show_comment">
                        <span ng-if="item.show_comment">收起</span>评论
                    </span>
                </div>
            </div>
            <div ng-if="item.show_comment" class="comment-block" comment-block answer-id="item.id">
            </div>
            <div class="hr fl"></div>
        </div>
        <div ng-if="Timeline.pending" class="tac">加载中...</div>
        <div ng-if="Timeline.no_more_data" class="tac">没有更多数据了</div>
    </div>
</div>