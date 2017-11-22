module.exports = {
  template: require('../../views/views_Module/work.html'),
  controller: workController,
  controllerAs: 'vm'
};

/** @ngInject */
function workController($http) {
  var vm = this;

  // $http.get('http://localhost:8000/works')
  // .then(function(response) {
  // 	vm.works = response.data;
  // 	console.log(vm.works);
  // });
}
