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
    var url = document.URL;
    var id = url.slice(60);
    ajaxAuthGet('http://localhost:8000/leaveMessages/'+id,
        function(response){
            console.log(response);
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



// 显示单个页面
// function addEventToMessage_btns (btn_view, btn_delete, id) {
    
//     btn_view.click(function() {

//         ajaxAuthGet('http://localhost:8000/leaveMessages/'+id,
//             function(response){
//                 // console.log(response);
//                 $('#panel_leavemessages').hide();
//                 leaveMessage_detail_obj = $('#panel_detail_leavemessage');
//                 var leaveMessages_detail = $('<div>', {class: 'item_leavemessage', style: 'border:1px solid gray; padding: 6px; margin-bottom: 15px;'});
//                 var name = $('<h4>', {html: response.name_leaveMessage});
//                 create = $('<small>', {html: response.created_at});
//                 name.append(create);
//                 leaveMessages_detail.append(name);
//                 leaveMessages_detail.append($('<p>', {html: response.message_leaveMessage}));
//                 show_contactWay(response, leaveMessages_detail);
//                 // addEventToMessages(leaveMessages_detail, response.id);
//                 leaveMessage_detail_obj.append(leaveMessages_detail);
//             },
//             function(response){console.log(response.statusText);});

//     });
// }