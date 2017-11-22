var angular = require('angular');

var contents = require('./scripts_Module/contents');

var guide = require('./scripts_Module/guide');
var movements = require('./scripts_Module/movements');
var movementDetails =require('./scripts_Module/movementDetails')
var works = require('./scripts_Module/works');
var work = require('./scripts_Module/work');
var writing = require('./scripts_Module/writing');
var contactus = require('./scripts_Module/contactus');
var aboutus = require('./scripts_Module/aboutus');

var register = require('./scripts_Module/register');
var login = require('./scripts_Module/loginSample');


var contentsModule = 'contents';
module.exports = contentsModule;

angular
  .module(contentsModule, [])
  .component('fountainContents', contents)

  .component('guide', guide)
  .component('movements', movements)
  .component('movementDetails', movementDetails)
  .component('works', works)
  .component('work', work)
  .component('writing', writing)
  .component('contactus', contactus)
  .component('aboutus',aboutus)
  .component('register', register)
  .component('login', login);
