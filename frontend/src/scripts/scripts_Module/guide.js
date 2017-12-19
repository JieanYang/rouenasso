module.exports = {
  template: require('../../views/views_Module/guide.html'),
  controller: GuideController,
  controllerAs: 'vm'
};

/** @ngInject */
function GuideController($http) {
  var vm = this;
  
  url = window.location.href.slice(38);
  vm.tab = parseInt(url);
  
  if(vm.tab === 8){
      $http.get('../../databases/guide.json')
      .then(function(response){
          vm.data_8 = {};
          vm.data_8.banks = response.data.银行.法国三大银行;
          vm.data_8.RIB = response.data.银行.RIB;
          vm.data_8.shouxu = response.data.银行.手续;
          vm.data_8.account = response.data.银行.账户类型;
          vm.data_8.card = response.data.银行.银行卡;
          vm.data_8.check = response.data.银行.支票;
          vm.data_8.cash = response.data.银行.现金;
      });
  }else if(vm.tab === 9){
      $http.get('../../databases/guide.json')
      .then(function(response){
          vm.data_9 = response.data.应用推荐;
    });
  }
}
