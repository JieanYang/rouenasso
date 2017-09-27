var angular = require('angular');

var contents = require('./contents');

var contentsModule = 'contents';

module.exports = contentsModule;

angular
  .module(contentsModule, [])
  .component('fountainContents', contents);
