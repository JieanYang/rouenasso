module.exports = {
  template: require('../../views/views_Module/work.html'),
  controller: workController,
  controllerAs: 'vm'
};

/** @ngInject */
function workController($http, $location, $sce) {
  var vm = this;

  vm.id=$location.url().slice(12);
  $http.get('https://api.acecrouen.com/posts/'+vm.id+'/noauth')
  .then(function(response) {
  	vm.work = $sce.trustAsHtml(response.data.html_content);
  });
}
