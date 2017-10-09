var angular = require('angular');

var contents = require('./contents');
var data = require('./data');

var contentsModule = 'contents';

module.exports = contentsModule;

angular
  .module(contentsModule, [])
  .component('fountainContents', contents)
  .component('testData', data);
