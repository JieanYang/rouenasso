module.exports = {
  template: require('../../views/views_Module/guides.html'),
  controller: GuidesController,
  controllerAs: 'vm'
};

/** @ngInject */
function GuidesController($http) {
  var vm = this;
  // vm.tab=1;

  // vm.data_8 = {};

  // $http.get('../../databases/guide.json')
  // .then(function(response){
  // 	vm.data_9 = response.data.应用推荐;

  //   vm.data_8.banks = response.data.银行.法国三大银行;
  //   vm.data_8.RIB = response.data.银行.RIB;
  //   vm.data_8.shouxu = response.data.银行.手续;
  //   vm.data_8.account = response.data.银行.账户类型;
  //   vm.data_8.card = response.data.银行.银行卡;
  //   vm.data_8.check = response.data.银行.支票;
  //   vm.data_8.cash = response.data.银行.现金;

  // 	console.log(vm.data_8);  
  // });
}
