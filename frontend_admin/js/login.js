// ajax - check if logged in
function checkLoginInLoginPage() {
    return attempt(Cookies.get('Authorization'), function (response) {
        auth = Cookies.get('Authorization');
        $("#loader").removeClass("show");
        $("#btn-submit").prop('disabled', false);
        window.location.replace("index.html");
    }, function () {
        Cookies.remove('Authorization');
        window.location.replace("login.html");
    });
}

function attemptLogin() {    
    var email = $('#email').val();
    var pw = $('#password').val();
    var auth = 'Basic ' + btoa(email + ':' + pw);

    $("#loader").addClass("show");
    $("#btn-submit").prop('disabled', true);

    attempt(auth, function (response) {
        if(response.department == "主席团" || response.department == "秘书部" || response.department == "宣传部"){
	        $("#hint").text("欢迎，" + response.name);
	        $("#hint").css('color', 'green');
	        $("#hint").show();
	        $("#loader").removeClass("show");

        	setAuthCookie(auth);
	        setTimeout(
	            function () {
	                window.location.replace("index.html");
	            }, 1500);
        } else {
	        $("#hint").text("你无权限登陆");
	        $("#hint").css('color', 'red');
	        $("#hint").show();
	        $("#btn-submit").prop('disabled', false);
	        $("#loader").removeveClass("show");
        }
    }, function (response) {
        $("#hint").text("邮箱或密码错误");
        $("#hint").css('color', 'red');
        $("#hint").show();
        $("#btn-submit").prop('disabled', false);
        $("#loader").removeClass("show");
    });
    
    return false;
}

