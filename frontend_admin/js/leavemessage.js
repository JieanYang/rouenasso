var auth = null;

$(window).on('load', function () {
    // show loader
    $("#loader").addClass("show");

    // logout btn
    $("#btn-logout").click(function () {
        logout();
    });

    // login check
    $.when(checkLogin()).done(function () {
        $.when(ajaxLeavemessage()).done(function () {
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


function ajaxLeavemessage() {
  ajaxAuthGet('http://localhost:8000/leaveMessages',
    function(response){

      var leaveMessages_obj = $('#panel_leavemessage');

      $.each(response, function(index, item){
        var leaveMessages_item = $('<div>', {class: 'item_leavemessage', style: 'border:1px solid gray; padding: 6px; margin-bottom: 15px;'});
        leaveMessages_item.append($('<h4>', {html: item.name_leaveMessage}));
        leaveMessages_item.append($('<p>', {html: item.message_leaveMessage}));
        show_contactWay(item, leaveMessages_item);
        leaveMessages_obj.append(leaveMessages_item);
      });
    },
    function(response){console.log(response.statusText);})
}

function show_contactWay(item, leaveMessages_item) {
    if(item.agreeContact_leaveMessage == 1){
    if(item.contactWay_leaveMessage == 'email'){
      leaveMessages_item.append($('<p>', {html: "联系方式: "+item.email_leaveMessage}));
    }else if(item.contactWay_leaveMessage == 'phone'){
      leaveMessages_item.append($('<p>', {html: "联系方式: "+item.phone_leaveMessage}));
    }
    }
}
