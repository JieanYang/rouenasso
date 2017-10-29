module.exports = {
  template: require('../../views/views_Module/register.html'),
  controller: registerController,
  controllerAs: 'vm'
};

/** @ngInject */
function registerController() {
  var vm = this;
//   $http
// .get('http://localhost:8000/test')
// .then(function (response) {
//   vm.contents = response.data;
//   $log.log(vm.contents);
// });
  var submit = function ($log) {
    $log.log('a');
  };
  vm.submit = submit;
}
