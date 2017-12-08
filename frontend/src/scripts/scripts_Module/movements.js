module.exports = {
  template: require('../../views/views_Module/movements.html'),
  controller: movementsController,
  controllerAs: 'vm'
};

/** @ngInject */
function movementsController($http) {
  var vm = this;

  $http.get('https://api.acecrouen.com//posts/category/1')//活动类型
  .then(function(response){
  	vm.data = response.data;
  	vm.id=0;

  	console.log(vm.data)
  });
}
