module.exports = {
  template: require('../../views/views_Module/writing_detail.html'),
  controller: writingDetailController,
  controllerAs: 'vm'
};

/** @ngInject */
function writingDetailController($http, $location, $sce) {
  var vm = this;
    
  // vm.id=$location.url().slice(12);
  // $http.get('http://localhost:8000/works/'+vm.id)
  // .then(function(response) {
  //   vm.work = $sce.trustAsHtml(response.data.html_work);
  // });
}
