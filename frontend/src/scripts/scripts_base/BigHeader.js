module.exports = {
  template: require('../../views/views_base/BigHeader.html'),
  controller: Controller,
  controllerAs: 'controller'
};

var mainjs = require('../../js/main.js');

function Controller() {
  angular.element(function () {
    mainjs.initBigHeader();
  });
}