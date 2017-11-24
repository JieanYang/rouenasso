module.exports = {
  template: require('../../views/views_Module/contactus.html'),
  controller: contactusController,
  controllerAs: 'vm'
};

/** @ngInject */
function contactusController($http) {
	var vm = this;
	vm.message = "您的留言已经提交到学联处！";
	vm.showMessage=false;
	vm.channels = [{value:"phone", label:"Tel."}, {value:"email",label:"Email"}];

  // vm.feedback = {mychannel:"", firstName:"", lastName:"", agree:false, email:"" };
	vm.feedback = {name_leaveMessage:"", phone_leaveMessage:"", email_leaveMessage:"",
   agreeContact_leaveMessage:false, contactWay_leaveMessage:"", message_leaveMessage:""};

   // vm.feedback = {name_leaveMessage:"杜甫", phone_leaveMessage:"0123456789", email_leaveMessage:"dufu@test.com",
   // agreeContact_leaveMessage:false, contactWay_leaveMessage:"", message_leaveMessage:"我是李白大人的兄弟，敢动他就是在我头上动土！"};


   // console.log(feedback.reset);
   // vm.a = function (){
   // 	vm.feedback = {name_leaveMessage:"", phone_leaveMessage:"", email_leaveMessage:"",
   // agreeContact_leaveMessage:false, contactWay_leaveMessage:"", message_leaveMessage:""};
   // 	  feedbackForm.$setPristine();????
   // }

 
	vm.sendFeedback = function() {
		
		$http.post("http://localhost:8000/leaveMessages", vm.feedback)
		.then(function (response) {
			console.log(response);
			if(response.data.msg == "success") {
					vm.feedback = {name_leaveMessage:"", phone_leaveMessage:"", email_leaveMessage:"",
								   agreeContact_leaveMessage:false, contactWay_leaveMessage:"", message_leaveMessage:""};
					vm.showMessage=true;	
			}
		});
	}

}
