module.exports = {
  template: require('../../views/views_Module/writing_detail.html'),
  controller: writingDetailController,
  controllerAs: 'vm'
};

/** @ngInject */
function writingDetailController($http, $location, $sce) {
  var vm = this;
    
  vm.id=$location.url().slice(14);
  $http.get('http://localhost:8000/posts/'+vm.id+'/noauth')
  .then(function(response) {
    vm.writing = $sce.trustAsHtml(response.data.html_content);
  });
}
