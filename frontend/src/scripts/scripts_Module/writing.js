module.exports = {
  template: require('../../views/views_Module/writing.html'),
  controller: writingController,
  controllerAs: 'vm'
};

/** @ngInject */
function writingController($http) {
  var vm = this;
    
   $http.get('http://localhost:8000/writings')
  .then(function(response){
  	vm.writings = response.data;

  	console.log(vm.writings)
  });
}
