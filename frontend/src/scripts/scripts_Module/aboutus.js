module.exports={
  template:require('../../views/views_Module/aboutus.html'),
  controller:AboutusController,
  controllerAs:'vm',
};
function AboutusController(){
  var vm = this;
  vm.tabchannel=[{label:"中文",value:1},
  {label:"English",value:2},
    {label:"français",value:3}];

    vm.tab=1;
  //
  // vm.show = function（）{
  //       console.log(vm.tab);
  //   };



}
