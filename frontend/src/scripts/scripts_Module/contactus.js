module.exports = {
  template: require('../../views/views_Module/contactus.html'),
  controller: contactusController,
  controllerAs: 'vm'
};

/** @ngInject */
function contactusController() {
  var vm = this;
  vm.channels = [{value:"tel", label:"Tel."}, {value:"Email",label:"Email"}];

  vm.feedback = {mychannel:"", firstName:"", lastName:"", agree:false, email:"" };
}
