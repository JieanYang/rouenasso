module.exports = {
  template: require('../../views/views_Module/guide.html'),
  controller: GuideController,
  controllerAs: 'vm'
};

/** @ngInject */
function GuideController() {
  var vm = this;
  vm.tab=0;
}
