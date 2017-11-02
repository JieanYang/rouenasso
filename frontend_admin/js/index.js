$(window).on('load', function () {
    // auth check
    var auth = Cookies.get('Authorization');
    attempt(auth, function (response) {
        $("#span-name").text(response.name);
    }, function () {
        window.location.replace("login.html");
    });
    
    // logout btn
    $("#btn-logout").click(function () {
        logout();
    });
});

