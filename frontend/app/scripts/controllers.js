'use strict';

angular.module('frontendApp')
		.controller('HomeController',['$scope','homeFactory',function($scope,homeFactory){
			$scope.a = homeFactory.getA();
			$scope.b = homeFactory.getB();
		}]);
