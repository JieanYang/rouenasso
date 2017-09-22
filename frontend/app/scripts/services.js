'use strict';

angular.module('frontendApp')
		.service('homeFactory',function(){
			this.getA = function(){
				return "学联项目网站：前端";
			}
			this.getB = function(){
				return "这块是页面内容部分";
			}
		});