module.exports = {
  template: require('../../views/views_Module/works.html'),
  controller: worksController,
  controllerAs: 'vm'
};

/** @ngInject */
function worksController($http) {
  var vm = this;

  $http.get('http://localhost:8000/posts/category/2')
  .then(function(response) {
  	works = response.data;
    
    works.forEach(function(w) {
      w.preview_text = angular.fromJson(w.preview_text);
    });
    
    vm.works = works;
  	console.log(works);
  });
}