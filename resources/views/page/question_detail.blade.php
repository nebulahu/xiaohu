<div ng-controller="QuestionDetailController" class="container question-detail">
    <div class="card">
        <h1>[: Question.current_question.title :]</h1>
        <div class="desc">[: Question.current_question.desc :]</div>
        <div class="comment">[: Question.current_question.updated_at :]</div>
        <div>
            <span class="gray">[: Question.current_question.answers_with_user_info.length || 0 :]个回答</span>
        </div>
        <small ng-if="his.id == Question.current_question.user_id" class="gray" ng-click="Question.show_update_form = !Question.show_update_form">
            <span ng-if="Question.show_update_form">取消</span>修改问题
        </small>
        <form ng-if="Question.show_update_form" name="question_add_form" ng-submit="Question.update()" class="well gray_card">
            <div class="input-group">
                <label>问题标题</label>
                <input name="title" type="text" ng-model="Question.current_question.title" ng-minlength="5" ng-maxlength="255" required>
            </div>
            <div class="input-group">
                <label>问题描述</label>
                <textarea name="desc" type="text" ng-model="Question.current_question.desc"></textarea>
            </div>
            <div class="input-group">
                <button ng-disabled="question_add_form.$invalid" class="primary" type="submit">提交</button>
            </div>
        </form>
        <div class="hr"></div>
        <div class="answer-block feed item clearfix">
            <dvi ng-if="!helper.obj_length(Question.current_question.answers_with_user_info)">
                <div class="gray tac well">还没有回答，快来抢沙发~</div>
                <div class="hr"></div>
            </dvi>
            <div ng-if="!Question.current_answer_id || Question.current_answer_id == item.id"
                 ng-repeat="item in Question.current_question.answers_with_user_info track by $index"
                 class="clearfix">
                <div class="vote tac">
                    <div ng-click="Question.vote({id:item.id,vote:1})" class="up">赞[: item.upvote_count :]</div>
                    <div ng-click="Question.vote({id:item.id,vote:2})" class="down">踩[: item.downvote_count :]</div>
                </div>
                <div class="feed-item-content">
                    <div>
                        <div><span ui-sref="user({id:item.user.id})" >[: item.user.username :]</span></div>
                        <div>[: item.content :]
                            <div class="action-set">
                                <span ng-click="item.show_comment = !item.show_comment">
                                    <span ng-if="item.show_comment">收起</span>评论
                                </span>
                                <span class="gray">
                                    <span class="gray" ng-if="item.user_id == his.id">
                                        <span ng-click="Answer.answer_form = item" >编辑</span>
                                        <span ng-click="Answer.delete(item.id)">删除</span>
                                    </span>
                                    <span ui-sref="question.detail({id:Question.current_question.id,answer_id:item.id})">[: item.updated_at :]</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div ng-if="item.show_comment" class="comment-block" comment-block answer-id="item.id">
                </div>
                <div class="hr fl"></div>
            </div>
        </div>
        <form ng-submit="Answer.add_or_update(Question.current_question.id)" name="answer_form" class="answer_form">
            <div class="input-group">
                <textarea name="content" type="text" ng-model="Answer.answer_form.content" required placeholder="添加回答"></textarea>
            </div>
            <div class="input-group">
                <button ng-disabled="answer_form.$invalid" class="primary" type="submit">提交</button>
            </div>
        </form>
    </div>
</div>