var angular = require('angular');

var contentsModule = require('./app/contentsModule/index');
require('angular-ui-router');
var routesConfig = require('./routes');

var main = require('./app/main');
var header = require('./app/views/header');
var footer = require('./app/views/footer');

require('./index.css');

angular
  .module('app', [contentsModule, 'ui.router'])
  .config(routesConfig)
  .component('app', main)
  .component('fountainHeader', header)
  .component('fountainFooter', footer);
