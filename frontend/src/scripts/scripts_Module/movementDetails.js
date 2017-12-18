module.exports = {
  template: require('../../views/views_Module/movementDetails.html'),
  controller: movementDetailsController,
  controllerAs: 'vm'
};

/** @ngInject */
function movementDetailsController($http, $location, $sce) {
  var vm = this;

  vm.id=$location.url().slice(16);
  // console.log(vm.id)
  $http.get('https://api.acecrouen.com/posts/'+vm.id+'/noauth')
  .then(function(response) {
  	vm.movement = $sce.trustAsHtml(response.data.html_content);
    vm.title = response.data.title;
    vm.published = response.data.published_at;
  });

}
