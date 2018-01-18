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
        
        $.when(ajaxUsersTable()).done(function () {
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
        $("#span-name").text(response.department+' '+response.name);
    }, function () {
        window.location.replace("login.html");
    });
}

// ajax - full calendar
function ajaxUsersTable() {
    ajaxAuthGet('https://api.acecrouen.com/users',
        function (response) {

            var table_obj = $('#listOfUsers');

            $.each(response, function (index, item) {
                var table_row = $('<tr>');
                table_row.append($('<td>', {
                    html: item.id
                }));
                table_row.append($('<td>', {
                    html: item.name
                }));
                table_row.append($('<td>', {
                    html: item.email
                }));
                table_row.append($('<td>', {
                    html: item.department
                }));
                table_row.append($('<td>', {
                    html: item.position
                }));
                table_row.append($('<td>', {
                    html: item.school
                }));
                table_obj.append(table_row);
            });

            responsiveUsersTable();
        },
        function (response) {
            $('#listOfUsers').after('error').remove();
        });
}

function responsiveUsersTable() {
    $('#listOfUsers').DataTable({
        responsive: true,
        bAutoWidth: true,
        // columnDefs: [{
        //     targets: 1,
        //     render: function (data, type, full, meta) {
        //         if (type === 'display') {
        //             data = data + '<div class="links">' +
        //                 '<a href="#" class="btn-view">查看</a> ' +
        //                 '<a href="#" class="btn-edit">更新信息</a> ' 
        //                 //+ '<a href="#" class="btn-delete">删除</a> ' +
        //                 '</div>';
        //         }

        //         return data;
        //     }
        // }]
    });

//     function initUserTableButtons(){

//     }

// initUserTableButtons();
// $('#listOfUsers').on('draw.dt', function () {
//         initUserTableButtons();
//     });
}


// function closeModelView() {
//   $('.fullbg').removeClass('show');
//   $('#model_view').removeClass('show');
// }
