var angular = require('angular');

var contentsModule = require('./scripts/index');
require('angular-ui-router');
var routesConfig = require('./routes');

var main = require('./scripts/main');
var header = require('./scripts/scripts_base/header');
var footer = require('./scripts/scripts_base/footer');

require('./styles/index.css');

angular
  .module('app', [contentsModule, 'ui.router'])
  .config(routesConfig)
  .component('app', main)
  .component('fountainHeader', header)
  .component('fountainFooter', footer);
