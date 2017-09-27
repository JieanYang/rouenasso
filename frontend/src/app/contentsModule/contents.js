module.exports = {
  template: require('./contents.html'),
  controller: ContentsController,
  controllerAs: 'vm'
};

/** @ngInject */
function ContentsController($http) {
  var vm = this;

  $http
.get('app/contentsModule/contents.json')
.then(function (response) {
  vm.contents = response.data;
});
}
