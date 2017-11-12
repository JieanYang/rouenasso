module.exports = {
  template: require('../../views/views_Module/contents.html'),
  controller: ContentsController,
  controllerAs: 'controller'
};

/** @ngInject */
function ContentsController($http, $sce) {
  var vm = this;

  $http
.get('../../databases/contents.json')
.then(function (response) {
  vm.contents = response.data;
});

  $http
.get('//api.acecrouen.com/posts/category/99?latest=true')
.then(function (response) {
  vm.announcement = $sce.trustAsHtml(response.data.html_content);
});
}
