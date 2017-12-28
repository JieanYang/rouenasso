module.exports = {
  template: require('../../views/views_Module/register.html'),
  controller: registerController,
  controllerAs: 'vm'
};

/** @ngInject */
function registerController($http) {
  var vm = this;
  // 注册链接
  var link = window.location.href.slice(36);
  //for the tag selection ng-options
  // vm.department_channels=[
  // 	{label:"主席团", value:"ZHUXITUAN"}, 
  // 	{label:"组织部", value:"ZUZHIBU"}, 
  // 	{label:"宣传部", value:"XUANCHUANBU"}, 
  // 	{label:"外联部", value:"WAILIANBU"}, 
  // 	{label:"秘书部", value:"MISHUBU"},
  // 	{label:"安全部", value:"XIANGMUKAIFABU"}
  // 	];

  // vm.positions = [
  // 	{label:"主席", value:"ZHUXI"},
  // 	{label:"副主席", value:"FUZHUXI"},
  // 	{label:"部长", value:"BUZHANG"},
  // 	{label:"副部长", value:"FUBUZHANG"},
  // 	{label:"成员", value:"CHENGYUAN"}
  // ];

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

  	$http.post('https://api.acecrouen.com/register/'+link, vm.register, true)
  	.then(function(response) {
  		if(response.data.msg){
  			vm.message = response.data.msg;
  			vm.response = vm.message;
  			clearForm();
			$('#alert_register').text(vm.response);
  		}
  		if(response.data.email){
  			vm.message = response.data.email;
  			vm.response = vm.message;
  			clearForm();
  			$('#alert_register').text(vm.response);
  		}
  		
  	},function(){
  		$('#alert_register').text("It meets an error on server!");
  	});
  };

  function clearForm(){
  	$('#email').val('');
  	$('#password').val('');
  	$('#password_confirm').val('');
  	$('#name').val('');
  	// $('#department').val('');
  	// $('#position').val('');
  	$('#school').val('');
  	$('#phone_number').val('');
  	$('#birthday').val('');
  	$('#arrive_date').val('');
  }
}
