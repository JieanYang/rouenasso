var angular = require('angular');

var contents = require('./scripts_Module/contents');
var data = require('./scripts_Module/data');

var contentsModule = 'contents';

module.exports = contentsModule;

angular
  .module(contentsModule, [])
  .component('fountainContents', contents)
  .component('testData', data);
