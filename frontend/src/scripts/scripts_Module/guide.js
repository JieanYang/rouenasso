module.exports = {
  template: require('../../views/views_Module/guide.html'),
  controller: GuideController,
  controllerAs: 'vm'
};

/** @ngInject */
function GuideController($http) {
  var vm = this;
  vm.tab=0;

  $http.get('../../databases/guide.json')
  .then(function(response){
  	vm.data_9 = response.data.应用推荐;
  	console.log(vm.data_9);
  });
}
