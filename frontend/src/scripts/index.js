var angular = require('angular');

var contents = require('./scripts_Module/contents');
var guide = require('./scripts_Module/guide');
var register = require('./scripts_Module/register');
var contactus = require('./scripts_Module/contactus');
var login = require('./scripts_Module/loginSample');

var contentsModule = 'contents';

module.exports = contentsModule;

angular
  .module(contentsModule, [])
  .component('fountainContents', contents)
  .component('guide', guide)
  .component('contactus', contactus)

  .component('register', register)

  .component('login', login);
