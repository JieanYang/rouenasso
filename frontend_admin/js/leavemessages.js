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
            // var url = document.URL;
            // alert(url);
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

// 显示目录
function ajaxLeavemessage() {
  ajaxAuthGet('http://localhost:8000/leaveMessages',
    function(response){

      var leaveMessages_obj = $('#panel_leavemessages');

      $.each(response, function(index, item){
        var leaveMessages_item = $('<div>', {class: 'item_leavemessage', style: 'border:1px solid gray; padding: 6px; margin-bottom: 15px;'});
        leaveMessages_name = $('<h4>', {html: item.name_leaveMessage});
        leaveMessages_create = $('<small>', {html: item.created_at});
        leaveMessages_name.append(leaveMessages_create);
        leaveMessages_item.append(leaveMessages_name);
        leaveMessages_item.append($('<p>', {html: item.message_leaveMessage}));
        show_contactWay(item, leaveMessages_item);
        addEventToMessages(leaveMessages_item, item.id);
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

function addEventToMessages(leaveMessages_item, id) {
        leaveMessages_item.mouseenter(function() {
            btns = $('<div>', {class: 'btns_leaveMessage'});
            btn_view = $('<a>', {class: 'btn btn-outline btn-primary', html: '查看', style:'margin-right: 10px;', href: 'leavemessages.html?id='+id});
            btn_delete = $('<a>', {class: 'btn btn-outline btn-danger', html: '删除'});
            // addEventToMessage_btns(btn_view, btn_delete, id);
            btns.append(btn_view,btn_delete);
            $(this).append(btns);
        });
        leaveMessages_item.mouseleave(function(){
            $(this).children(".btns_leaveMessage").remove();
         });
    
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