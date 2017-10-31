var angular = require('angular');

var contentsModule = require('./scripts/index');
require('angular-ui-router');
var routesConfig = require('./routes');

var main = require('./scripts/main');
var bigHeader = require('./scripts/scripts_base/BigHeader');
var smallHeader = require('./scripts/scripts_base/SmallHeader');
var footer = require('./scripts/scripts_base/footer');

require('./styles/index.css');
require('./styles/guide.css');
require('./styles/register.css');

angular
  .module('app', [contentsModule, 'ui.router'])
  .config(routesConfig)
  .component('app', main)
  .component('bigHeader', bigHeader)
  .component('smallHeader', smallHeader)
  .component('fountainFooter', footer);
