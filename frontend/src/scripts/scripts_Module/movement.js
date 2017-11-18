module.exports = {
  template: require('../../views/views_Module/movement.html'),
  controller: movementController,
  controllerAs: 'vm'
};

/** @ngInject */
function movementController($http) {
  var vm = this;
}
