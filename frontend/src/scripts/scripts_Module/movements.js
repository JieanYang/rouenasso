module.exports = {
  template: require('../../views/views_Module/movements.html'),
  controller: movementsController,
  controllerAs: 'vm'
};

/** @ngInject */
function movementsController($http) {
  var vm = this;

  $http.get('http://localhost:8000/movements')
  .then(function(response){
  	vm.data = response.data;

  	// console.log(vm.data)
  });
}
