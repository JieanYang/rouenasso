module.exports = {
  template: require('../../views/views_Module/register.html'),
  controller: registerController,
  controllerAs: 'vm'
};

/** @ngInject */
function registerController($http) {
  var vm = this;
  //for the tag selection ng-options
  vm.department_channels=[{label:"项目开发部", value:"项目开发部"}, 
  						  {label:"组织部", value:"组织部"},
  						  {label:"安全部", value:"安全部"}];
  vm.positions = [{label:"成员", value:"成员"}];

  vm.birthday;//input birthday
  vm.arrive_date;//input arrive_date

  vm.password_confirm;
  
  //initialize information of register
  // vm.register = {				
				// 	"name" : "b",
				// 	"email" : "b@test.com",
				// 	"department":"项目开发部",
				// 	"position": "成员",
				// 	"school": "INSA",
				// 	"phone_number": "0654983278",
				// 	"birthday": "1995-10-29",
				// 	"arrive_date": "2025-10-18",
				// 	"password": "yang"
				// }

  vm.sendRegister = function () {
  	vm.register.birthday = vm.birthday.toLocaleDateString('zh-Hans-CN');
  	vm.register.arrive_date = vm.arrive_date.toLocaleDateString('zh-Hans-CN');

  	console.log(vm.register);

  	$http.post('http://localhost:8000/register', vm.register, true)
  	.then(function(response) {
  		if(response.data.msg){
  			vm.message = response.data.msg;
  		console.log(vm.message);
  		}
  		if(response.data.email){
  			vm.message = response.data.email;
  			console.log(vm.message);
  		}
  		
  	},function(){
  		console.log("It meets an error!");
  	});
  };
}
