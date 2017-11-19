module.exports = {
  template: require('../../views/views_Module/work.html'),
  controller: workController,
  controllerAs: 'vm'
};

/** @ngInject */
function workController($http) {
  var vm = this;
}
