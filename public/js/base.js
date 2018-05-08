/**
 * Created by 胡一天 on 2018/5/7.
 */
;(function(){
    'use strict';
    angular.module('xiaohu',['ui.router'])
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
                    templateUrl:'home.tpl'
                })
                .state('signup',{
                    url:'/signup',
                    templateUrl:'signup.tpl'
                })
                .state('login',{
                    url:'/login',
                    templateUrl:'login.tpl'
                })
        }])
        .service('UserService',[
            function(){
                var me = this;
                me.signup_data = {};
                me.signup = function(){

                }
        }])
        .controller('SignupController',[
            '$scope',
            'UserService',
            function($scope,UserService){
                $scope.User = UserService;
        }])
})();
