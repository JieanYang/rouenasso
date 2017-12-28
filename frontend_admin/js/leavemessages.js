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

// 显示目录
function ajaxLeavemessage() {
    ajaxAuthGet('https://api.acecrouen.com/leaveMessages',
        function (response) {


            var leaveMessages_obj = $('#panel_leavemessages');

            $.each(response, function (index, item) {

                var hour = (parseInt(item.created_at.split(' ')[1].split(':')[0])+1).toString();
                var cut1 = item.created_at.split(':')[0].split(' ')[0];
                var cut2 = item.created_at.split(':')[1];
                var cut3 = item.created_at.split(':')[2];
                item.created_at = cut1+' '+hour+':'+cut2+':'+cut3;

                var leaveMessages_item = $('<div>', {
                    class: 'item_leavemessage',
                    style: 'border:1px solid #D5D0D0; padding: 6px; margin-bottom: 15px;'
                });
                leaveMessages_name = $('<h4>', {
                    html: item.name_leaveMessage
                });
                leaveMessages_create = $('<small>', {
                    html: item.created_at
                });
                leaveMessages_name.append(leaveMessages_create);
                leaveMessages_item.append(leaveMessages_name);
                leaveMessages_item.append($('<p>', {
                    html: item.message_leaveMessage
                }));
                show_contactWay(item, leaveMessages_item);
                addMessagesBtns(leaveMessages_item, item.id);
                leaveMessages_obj.append(leaveMessages_item);
            });
        },
        function (response) {
            // console.log(response.statusText);
        })
}

function show_contactWay(item, leaveMessages_item) {
    if (item.agreeContact_leaveMessage == 1) {
        if (item.contactWay_leaveMessage == 'email') {
            leaveMessages_item.append($('<p>', {
                html: "联系方式: " + item.email_leaveMessage
            }));
        } else if (item.contactWay_leaveMessage == 'phone') {
            leaveMessages_item.append($('<p>', {
                html: "联系方式: " + item.phone_leaveMessage
            }));
        }
    }
}

function addMessagesBtns(leaveMessages_item, id) {
    leaveMessages_item.mouseenter(function () {
        btns = $('<div>', {
            class: 'btns_leaveMessage'

        });
        btn_view = $('<a>', {
            href: 'leavemessage_pageDetail.html?id=' + id,
            html: '查看',
            class: 'btn btn-outline btn-primary',
            style: 'margin-right: 10px;'
        });

        btn_delete = $('<a>', {
            html: '删除',
            class: 'btn btn-outline btn-danger'
        });
        addDeleteEvent(btn_delete, id);
        btns.append(btn_view, btn_delete);
        $(this).append(btns);
    });
    leaveMessages_item.mouseleave(function () {
        $(this).children(".btns_leaveMessage").remove();
    });

}

function addDeleteEvent(btn_delete, id) {
    btn_delete.click(function () {
        $(this).attr('id', 'delete');
        ajaxAuthDelete('https://api.acecrouen.com/leaveMessages/' + id, null,
            function (response) {
                // console.log(response.status);
                // console.log(response.msg);
                $('#delete').parent().parent().remove();
            },
            function (response) {
                // console.log(response.responseJSON.status);
                // console.log(response.responseJSON.msg);
                if (response.responseJSON.status == 400) {
                    $('#delete').parent().append($('<p>').text('帖子已删除').css('color', 'red'));
                }
                $('#delete').removeAttr("id");
            });
    });
}
