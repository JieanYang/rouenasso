var angular = require('angular');

var app = 'app';
module.exports = app;
require('angular-ui-router');
var routesConfig = require('./routes');

require('./index.css');

angular
  .module(app, ['ui.router'])
  .config(routesConfig);

var rouenasso = require('./app/rouenasso');

angular.module('app').component('app', rouenasso);
