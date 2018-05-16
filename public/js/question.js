/**
 * Created by 胡一天 on 2018/5/11.
 */
;(function(){
    'use strict';
    angular.module('question',[
            'answer'
        ])
        .service('QuestionService',[
            '$state',
            '$http',
            'AnswerService',
            function($state,$http,AnswerService){
                var me = this;
                me.new_question = {};
                me.current_question = {};
                me.data = [];
                me.its_answers = {};
                me.go_add_question = function(){
                    $state.go('question.add');
                }

                me.read = function(param){
                    return $http.post('/api/question/read',param)
                        .then(function(r){
                            if(r.data.status){
                                if(param.id){
                                    me.data[param.id] = me.current_question = r.data.data;
                                    me.its_answers = me.current_question.answers_with_user_info;
                                    me.its_answers = AnswerService.count_vote(me.its_answers);
                                }
                                else
                                    me.data = angular.merge({},me.data,r.data.data);
                                return r.data.data;
                            }
                            return r.data.data;
                        })
                }

                me.add = function(){
                    if(!me.new_question.title)
                        return;
                    $http.post('/api/question/add',me.new_question)
                        .then(function(r){
                            me.new_question = {};
                            $state.go('home');
                        },function(e){
                            console.log(e);
                        })
                }

                me.vote = function(conf){
                  var $r =  AnswerService.vote(conf)
                      if($r)
                        $r.then(function(r){
                            if(r)
                                me.update_answer(conf.id);
                    })
                }

                me.update_answer = function(answer_id){
                    $http.post('/api/answer/read',{id:answer_id})
                        .then(function(r){
                            if(r.data.status){
                                for(var i=0 ; i< me.its_answers.length; i++){
                                    var answer = me.its_answers[i];
                                    if(answer.id == answer_id){
                                        me.its_answers[i] = r.data.data;
                                        AnswerService.data[answer_id] = r.data.data;
                                    }
                                }
                            }
                        })
                }

                me.update = function(){
                    if(!me.current_question.title)
                        return;
                    return $http.post('/api/question/change',me.current_question)
                        .then(function(r){
                            if(r.data.status)
                                me.show_update_form = false;
                        },function(e){
                            console.log(e);
                    })
                }
        }])
        .controller('QuestionController',[
            '$scope',
            'QuestionService',
            function($scope,QuestionService){
                $scope.Question = QuestionService;
        }])
        .controller('QuestionAddController',[
            '$scope',
            '$state',
            'QuestionService',
            function($scope,$state,QuestionService){
                $scope.Question = QuestionService;
                if(!his.id)
                    $state.go('login');
        }])
        .controller('QuestionDetailController',[
            '$scope',
            '$stateParams',
            'AnswerService',
            'QuestionService',
            function($scope,$stateParams,AnswerService,QuestionService){
                $scope.Answer = AnswerService;
                QuestionService.read($stateParams);
                if($stateParams.answer_id)
                    QuestionService.current_answer_id = $stateParams.answer_id;
                else
                    QuestionService.current_answer_id = null;
        }])
})();