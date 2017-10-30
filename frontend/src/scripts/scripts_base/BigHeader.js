module.exports = {
  template: require('../../views/views_base/BigHeader.html'),
  controller: Controller,
  controllerAs: 'controller'
};

function Controller() {
  angular.element(function () {
    initBigHeader();
  });
}