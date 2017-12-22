var auth = null;

$(window).on('load', function () {
    // show loader
    $("#loader").addClass("show");

    // navigation
    importLeftNavigation();

    // logout btn
    $("#btn-logout").click(function () {
        logout();
    });

    // login check
    $.when(checkLogin()).done(function () {
        $.when(ajaxLeavemessage_pageDetail()).done(function () {
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


function ajaxLeavemessage_pageDetail() {
    var url = document.URL;
    var id = url.slice(71);
    console.log(id);

    ajaxAuthGet('https://api.acecrouen.com/leaveMessages/'+id,
        function(response){
            // console.log(response);
            $('#id').text(response.id);
            $('#create').text(response.created_at);
            $('#name').text(response.name_leaveMessage);
            $('#message').text(response.message_leaveMessage);
            $('#email').text(response.email_leaveMessage);
            $('#phone').text(response.phone_leaveMessage);
            show_contactWay(response, $('#contact'));
            $('#panel_detail_leavemessage').show();
        },
        function(response){console.log(response.statusText);});
}

function show_contactWay(response, leaveMessages_item) {
          if(response.agreeContact_leaveMessage == 1){
            if(response.contactWay_leaveMessage == 'email'){
              leaveMessages_item.text('可以，邮件优先');
            }else if(response.contactWay_leaveMessage == 'phone'){
              leaveMessages_item.text('可以，手机优先');
            }
          }
          else{
              leaveMessages_item.text('否');
          }
        }