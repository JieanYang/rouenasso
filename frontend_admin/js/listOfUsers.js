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
        $("#span-name").text(response.name);
    }, function () {
        window.location.replace("login.html");
    });
}

// ajax - full calendar
function ajaxUsersTable() {
    ajaxAuthGet('https://api.acecrouen.com/users',
        function (response) {
            console.log(response);

            var table_obj = $('#listOfUsers');

            $.each(response, function(index, item){
                 var table_row = $('<tr>');
                 table_row.append($('<td>', {html: item.id}));
                 table_row.append($('<td>', {html: item.name}));
                 table_row.append($('<td>', {html: item.email}));
                 table_row.append($('<td>', {html: item.department}));
                 table_row.append($('<td>', {html: item.position}));
                 table_row.append($('<td>', {html: item.school}));
                 table_obj.append(table_row);
            });

            responsivePostDeleteTable();
//         "id": 1,
 //        "name": "小何",
 //        "email": "xiaohe@test.com",
 //        "department": "主席团",
 //        "position": "主席",
 //        "school": "ESIGELEC",
 //        "phone_number": "06 05 04 03 02",
 //        "isWorking": 1,
 //        "isAvaible": 1,
 //        "birthday": "1993-01-01",
 //        "arrive_date": "2012-01-01",
 //        "dimission_date": "2018-01-01",
 //        "deleted_at": null,
 //        "created_at": "2017-12-19 21:25:07",
 //        "updated_at": null
        },
        function (response) {
            $('#listOfUsers').after('error').remove();
        });
}

function responsivePostDeleteTable() {
    $('#listOfUsers').DataTable({
        responsive: true,
        bAutoWidth: true
    });
}


// function closeModelView() {
//   $('.fullbg').removeClass('show');
//   $('#model_view').removeClass('show');
// }