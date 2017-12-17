module.exports = {
  template: require('../../views/views_Module/movements.html'),
  controller: movementsController,
  controllerAs: 'vm'
};

/** @ngInject */
function movementsController($http) {
  var vm = this;

  $http.get('https://api.acecrouen.com/posts/category/1')
  .then(function(response) {
  	movements = response.data;
  	movements.forEach(function(movement) {
  		movement.preview_text = angular.fromJson(movement.preview_text);
  	});
  	vm.movements = movements;
  	// console.log(vm.movements);
  });
}
