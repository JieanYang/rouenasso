module.exports = {
  template: require('../../views/views_Module/writing.html'),
  controller: writingController,
  controllerAs: 'vm'
};

/** @ngInject */
function writingController($http) {
  var vm = this;
    
  $http.get('https://api.acecrouen.com/posts/category/4')
  .then(function(response) {
  	writings = response.data;
  	writings.forEach(function(writing) {
  		writing.preview_text = angular.fromJson(writing.preview_text);
  	});
  	vm.writings = writings;
  	// console.log(vm.works)\;
  });
}
