var angular = require('angular');

var contents = require('./scripts_Module/contents');
var data = require('./scripts_Module/data');
var guide = require('./scripts_Module/guide');
var register = require('./scripts_Module/register');

var contentsModule = 'contents';

module.exports = contentsModule;

angular
  .module(contentsModule, [])
  .component('fountainContents', contents)
  .component('testData', data)
  .component('guide', guide)
  .component('register', register);
