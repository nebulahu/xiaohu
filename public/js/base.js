/**
 * Created by 胡一天 on 2018/5/7.
 */
;(function(){
    'use strict';
    window.his = {
        id: parseInt($('html').attr('user_id'))
    }
    window.helper = {};
    helper.obj_length = function(obj){
        if(obj)
            return Object.keys(obj).length;
        else
            return false;
    }
    angular.module('xiaohu',[
        'ui.router',
        'common',
        'question',
        'user',
        'answer'
        ])
        .config(['$interpolateProvider',
            '$stateProvider',
            '$urlRouterProvider',
            function($interpolateProvider,$stateProvider,$urlRouterProvider){
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home');

            $stateProvider
                .state('home',{
                    url:'/home',
                    templateUrl:'/tpl/page/home'
                })
                .state('signup',{
                    url:'/signup',
                    templateUrl:'/tpl/page/signup'
                })
                .state('login',{
                    url:'/login',
                    templateUrl:'/tpl/page/login'
                })

                .state('question',{
                    abstract:true,
                    url:'/question',
                    template:'<div ui-view></div>',
                    controller:'QuestionController'
                })
                .state('question.add',{
                    url:'/add',
                    templateUrl:'/tpl/page/question_add'
                })
                .state('question.detail',{
                    url:'/detail/:id?answer_id',
                    templateUrl:'/tpl/page/question_detail'
                })

                .state('user',{
                    url:'/user/:id',
                    templateUrl:'/tpl/page/user'
                })
        }])
        .controller('BaseController',[
            '$scope',
            function($scope){
                $scope.his = his;
                $scope.helper = helper;
        }])
})();
