module.exports = {
  template: require('../../views/views_Module/works.html'),
  controller: worksController,
  controllerAs: 'vm'
};

/** @ngInject */
function worksController($http) {
  var vm = this;

  $http.get('http://localhost:8000/works')
  .then(function(response) {
  	vm.works = response.data;
  	console.log(vm.works);
  })
}
