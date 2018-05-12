<div ng-controller="HomeController" class="home card container">
    <h1>最新动态</h1>
    <div class="hr"></div>
    <div classs="item-set">
        <div ng-repeat="item in Timeline.data" class="feed item clearfix">
            <div ng-if="item.question_id" class="vote tac">
                <div ng-click="Timeline.vote({id:item.id,vote:1})" class="up">赞[: item.upvote_count :]</div>
                <div ng-click="Timeline.vote({id:item.id,vote:2})" class="down">踩[: item.downvote_count :]</div>
            </div>
            <div class="feed-item-content">
                <div ng-if="item.question_id" class="content-act">[: item.user.username :]添加了回答</div>
                <div ng-if="!item.question_id" class="content-act">[: item.users.username :]添加了提问</div>
                <div class="title">[: item.title :]</div>
                <div class="content-owner">[: item.user_id :]
                    <span class="desc">旅游，摄影，生活，理财～欢迎关注哦～</span>
                </div>
                <div ng-if="item.question_id" class="content-main">
                    [: item.content :]
                </div>
                <div ng-if="!item.question_id" class="content-main">
                    [: item.desc :]
                </div>
                <div class="action-set">
                    <div class="comment">评论</div>
                </div>
                <div class="comment-block">
                    <div class="hr"></div>
                    <div class="comment-item-set">
                        <div class="rect"></div>
                        <div class="comment-item clearfix">
                            <div class="user fl">胡一天</div>
                            <div class="comment-content fr">
                                普通人网购时看中销量和评价,普通人网购时看中销量和评价，普通人网购时看中销量和评价，普通人网购时看中销量和评价
                            </div>
                        </div>
                        <div class="comment-item clearfix">
                            <div class="user fl">胡一天</div>
                            <div class="comment-content fr">
                                普通人网购时看中销量和评价
                            </div>
                        </div>
                        <div class="comment-item clearfix">
                            <div class="user fl">exile</div>
                            <div class="comment-content fr">
                                普通人网购时看中销量和评价,普通人网购时看中销量和评价，普通人网购时看中销量和评价，普通人网购时看中销量和评价
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr fl"></div>
        </div>
        <div ng-if="!Timeline.no_more_data" class="tac">加载中...</div>
        <div ng-if="Timeline.no_more_data" class="tac">没有更多数据了</div>
    </div>
</div>