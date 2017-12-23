module.exports = {
  template: require('../../views/views_Module/works.html'),
  controller: worksController,
  controllerAs: 'vm'
};

/** @ngInject */
function worksController($http) {
  var vm = this;

  $http.get('https://api.acecrouen.com/posts/category/3')
  .then(function(response) {
  	works = response.data;
  	works.forEach(function(work) {
  		work.preview_text = angular.fromJson(work.preview_text);
      work.published_at = work.published_at.split(' ')[0];
  	});
  	vm.works = works;
  	// console.log(vm.works)\;
  });
}
