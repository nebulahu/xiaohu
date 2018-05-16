/**
 * Created by 胡一天 on 2018/5/11.
 */
;(function (){
    'use strict';
    angular.module('user',[
            'answer',
            'question',
        ])
        .service('UserService',[
            '$state',
            '$http',
            function($state,$http){
                var me = this;
                me.signup_data = {};
                me.login_data = {};
                me.data = {};
                me.read = function(id){
                    return $http.post('/api/user/read',{id:id})
                        .then(function(r){
                            //console.log('r',r);
                            if(r.data.status){
                                me.current_user = r.data.data;
                                // if(id === 'self')
                                //     me.data.self = r.data.data;
                            }else{
                                if(r.data.msg == 'invaild or login requried')
                                    $state.go('login');
                            }
                        })
                }

                me.signup = function(){
                    $http.post('/api/user/signup',me.signup_data)
                        .then(function(r){
                            if(r.data.status){
                                me.signup_data = {};
                                $state.go('login');
                            }
                        },function(e){
                            console.log('e',e);
                        })
                }
                me.login = function(){
                    $http.post('/api/user/login',me.login_data)
                        .then(function(r){
                            if(r.data.status){
                                location.href="/";
                            }else{
                                me.login_failed = true;
                            }
                        },function(e){

                        })
                }
                me.username_exists = function(){
                    $http.post('/api/user/exist',{username:me.signup_data.username})
                        .then(function(r){
                            if(r.data.status && r.data.data.count)
                                me.signup_username_exists = true;
                            else
                                me.signup_username_exists = false;
                        },function(e){
                            console.log('e',e);
                        })
                }
        }])
        .controller('SignupController',[
            '$scope',
            'UserService',
            function($scope,UserService){
                $scope.User = UserService;
                $scope.$watch(function(){
                    return UserService.signup_data;
                },function(n,o){
                    if(n.username != o.username)
                        return UserService.username_exists();
                },true);
        }])

        .controller('LoginController',[
            '$scope',
            'UserService',
            function($scope,UserService){
                $scope.User = UserService;
        }])

        .controller('UserController',[
            '$scope',
            '$stateParams',
            'UserService',
            'AnswerService',
            'QuestionService',
            function($scope,$stateParams,UserService,AnswerService,QuestionService){
                $scope.User = UserService;
                UserService.read($stateParams.id);
                QuestionService.read({user_id:$stateParams.id})
                    .then(function(r){
                        if(r)
                            UserService.his_questions = r;
                })
                AnswerService.read({user_id:$stateParams.id})
                    .then(function(r){
                        if(r)
                            UserService.his_answers = r;
                })
        }])
})();