module.exports = {
  template: require('./view/home.html'),
  controller: require('./scripts/controller')
}
;

angular.module('app').service('sampleService', require('./scripts/service'));
