/**
 * Created by 胡一天 on 2018/5/11.
 */
;(function(){
    'use strict';
    angular.module('answer',[])
        .service('AnswerService',[
            '$http',
            '$state',
            function($http,$state){
                var me = this;
                me.data = {};
                me.answer_form = {};
                me.count_vote = function(answers){
                    for(var i=0;i<answers.length;i++){
                        var votes,item = answers[i];
                        if(!item['question_id']) continue;
                        me.data[item.id] = item;
                        if(!item['users']) continue;
                        votes = item['users'];
                        item.upvote_count = 0;
                        item.downvote_count = 0;
                        if(votes){
                            for(var j = 0; j< votes.length; j++){
                                var v = votes[j];
                                if(v['pivot'].vote === 1)
                                    item.upvote_count++;
                                if(v['pivot'].vote === 2)
                                    item.downvote_count++;
                            }
                        }
                    }
                    return answers;
                }

                me.vote = function(conf){
                    if(!conf.id || !conf.vote){
                        console.log('id and vote required');
                        return;
                    }
                    var answer = me.data[conf.id],
                    users = answer.users;
                    if(answer.user_id == his.id){
                        console.log('不能给自己投票');
                        return false;
                    }
                    for(var i =0; i<users.length;i++){
                        if(users[i].id == his.id && conf.vote == users[i].pivot.vote){
                            conf.vote = 3;
                        }
                    }
                    return $http.post('/api/answer/vote',conf)
                        .then(function(r){
                        if(r.data.status)
                            return true;
                        else if(r.data.msg == 'login required')
                            $state.go('login');
                        else
                            return false;
                    },function(){
                            return false;
                    })
                }

                me.update_data = function(id){
                    // if(angular.isNumeric(input))
                    //     var id = input;
                    // if(angular.isArray(input))
                    //     var id_set = input;
                    return $http.post('/api/answer/read',{id:id})
                        .then(function(r){
                            me.data[id] = r.data.data;
                        })
                }

                me.read = function(param){
                    return $http.post('/api/answer/read',param)
                        .then(function(r){
                            if(r.data.status){
                                me.data = angular.merge({},me.data,r.data.data);
                            }
                            return r.data.data;
                        })
                }

                me.add_or_update = function(question_id){
                    if(!question_id){
                        console.log('question is required');
                        return;
                    }
                    me.answer_form.question_id = question_id;
                    if(me.answer_form.id)
                        $http.post('/api/answer/change',me.answer_form)
                            .then(function(r){
                                if(r.data.status){
                                    me.answer_form = {};
                                    console.log('update successfully!');
                                    $state.reload();
                                }
                            })
                    else
                        $http.post('/api/answer/add',me.answer_form)
                            .then(function(r){
                                if(r.data.status){
                                    me.answer_form = {};
                                    console.log('add successfully!');
                                    $state.reload();
                                }
                            })
                }

                me.delete = function(id){
                    if(!id){
                        console.log('id is required');
                        return;
                    }
                    $http.post('/api/answer/remove',{id:id})
                        .then(function(r){
                            if(r.data.status){
                                console.log('delete successfully!');
                                $state.reload();
                            }
                        })
                }

                me.add_comment = function(){
                    return $http.post('/api/comment/add/',me.new_comment)
                        .then(function(r){
                            if(r.data.status)
                                return true;
                            else
                                return false;
                    })
                }
        }])

        .directive('commentBlock',[
            '$http',
            'AnswerService',
            function($http,AnswerService){
                var o = {};
                o.templateUrl = 'comment.tpl';
                o.scope = {
                    answer_id: '=answerId',
                }
                o.link = function(sco,ele,attr){
                    sco.Answer = AnswerService;
                    sco._ = {};
                    sco.data = {};
                    sco.helper = helper;

                    function get_comment_list(){
                      return  $http.post('/api/comment/read/',{answer_id:sco.answer_id})
                            .then(function(r){
                                if(r.data.status)
                                    sco.data = angular.merge({},sco.data,r.data.data);
                        })
                    }

                    if(sco.answer_id)
                        get_comment_list();

                    sco._.add_comment = function(){
                        AnswerService.new_comment.answer_id = sco.answer_id;
                        AnswerService.add_comment()
                            .then(function(r){
                                AnswerService.new_comment = {};
                                get_comment_list();
                            })
                    }
                }
                return o;
            }
        ])
})();

