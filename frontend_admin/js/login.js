function attemptLogin() {    
    var email = $('#email').val();
    var pw = $('#password').val();
    var auth = 'Basic ' + btoa(email + ':' + pw);

    $("#loader").addClass("show");
    $("#btn-submit").prop('disabled', true);

    attempt(auth, function (response) {
        $("#hint").text("欢迎，" + response.name);
        $("#hint").css('color', 'green');
        $("#hint").show();
        $("#loader").removeClass("show");

        setAuthCookie(auth);

        setTimeout(
            function () {
                window.location.replace("index.html");
            }, 1500);
    }, function (response) {
        $("#hint").text("邮箱或密码错误");
        $("#hint").css('color', 'red');
        $("#hint").show();
        $("#btn-submit").prop('disabled', false);
        $("#loader").removeClass("show");
    });
    
    return false;
}

function attempt(auth, success, error) {
    return $.ajax({
        url: 'https://api.acecrouen.com/login',
        type: 'post',
        headers: {
            Authorization: auth
        },
        dataType: 'json',
        success: success,
        error: error
    });
}

function logout() {
    Cookies.remove('Authorization');
    window.location.replace("login.html");
}

function setAuthCookie(auth) {
    Cookies.set('Authorization', auth, {
        expires: 1 / 48 // 半小时失效
    });
}
