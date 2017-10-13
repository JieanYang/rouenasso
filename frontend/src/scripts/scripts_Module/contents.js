module.exports = {
  template: require('../../views/views_Module/contents.html'),
  controller: ContentsController,
  controllerAs: 'controller'
};

/** @ngInject */
function ContentsController($http) {
  var vm = this;

  $http
.get('../../databases/contents.json')
.then(function (response) {
  vm.contents = response.data;
});
}
