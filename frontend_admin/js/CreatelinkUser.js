var auth = null;

$(window).on('load', function () {
    // show loader
    $("#loader").addClass("show");

    // navigation
    importLeftNavigation();

    // login check
    $.when(checkLogin()).done(function () {
        // logout btn
        $("#btn-logout").click(function () {
            logout();
        });
        
        $.when(addEventCreateButton()).done(function () {
            // hide loader
            $("#loader").removeClass("show");
        });
    });
});

// ajax - check if logged in
function checkLogin() {
    return attempt(Cookies.get('Authorization'), function (response) {
        auth = Cookies.get('Authorization');
        setAuthCookie(auth);
        $("#span-name").text(response.name);
    }, function () {
        window.location.replace("login.html");
    });
}

function addEventCreateButton(){
    $('#createLinkButton').click(function(){
        var department = $("#department").val();
        var position = $("#position").val();
        if(department == "choice_department" || position == "choice_position"){
            $("#alert_createLink").text("请选择部门和职位");
            $("#alert_createLink").addClass("show");
        }else{
            $("#alert_createLink").removeClass("show");
            createLink(department,position);
        }
    });
}

function createLink(department, position) {
    ajaxAuthPost("http://localhost:8000/createlink",
        {"department": department, "position": position},
        function(response){
            console.log(response);
            $("#alert_response_link").text(response.msg + "  link:" + response.link)
            $("#alert_response_link").addClass("show");
        },
        function(response){
            console.log(response);
            $("#alert_createLink").text("服务器问题！");
            $("#alert_createLink").removeClass("show");
        }
        );
}