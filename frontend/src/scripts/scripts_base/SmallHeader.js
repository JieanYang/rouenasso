module.exports = {
  template: require('../../views/views_base/SmallHeader.html'),
  controller: Controller,
  controllerAs: 'controller'
};

function Controller() {
  angular.element(function () {
    initSmallHeader();
  });
}