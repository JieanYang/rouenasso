module.exports = {
  template: require('../../views/views_Module/work.html'),
  controller: workController,
  controllerAs: 'vm'
};

/** @ngInject */
function workController($http, $location, $sce) {
  var vm = this;
  url=$location.url();
  num=url.slice(url.indexOf('&')+4);
  vm.id=num;

  $http.get('https://api.acecrouen.com/posts/'+vm.id+'/noauth')
  .then(function(response) {
  	vm.work = $sce.trustAsHtml(response.data.html_content);
  	vm.title = response.data.title;
    vm.published = response.data.published_at;
  });
}
