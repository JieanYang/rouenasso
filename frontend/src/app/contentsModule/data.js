module.exports = {
  template: require('./data.html'),
  controller: DataController,
  controllerAs: 'vm'
};

/** @ngInject */
function DataController($http, $log) {
  var vm = this;
  $http
.get('http://localhost:8000/test')
.then(function (response) {
  vm.contents = response.data;
  $log.log(vm.contents);
});
}
