module.exports = {
  template: require('../../views/views_Module/writing.html'),
  controller: writingController,
  controllerAs: 'vm'
};

/** @ngInject */
function writingController($http) {
  var vm = this;
}
