module.exports = {
  template: require('../../views/views_Module/writing.html'),
  controller: writingController,
  controllerAs: 'vm'
};

/** @ngInject */
function writingController($http) {
  var vm = this;
    
   $http.get('https://api.acecrouen.com//posts/category/1')//活动类型
  .then(function(response){
  	vm.data = response.data;
  	vm.id=0;

  	console.log(vm.data)
  });
}
