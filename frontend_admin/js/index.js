var auth = null;

$(window).on('load', function () {
    $.when(checkLogin()).done(function () {
        // logout btn
        $("#btn-logout").click(function () {
            logout();
        });

        // dashboard
        $("#block-date").text((new Date).toLocaleDateString());
        $("#block-time").text((new Date).toLocaleTimeString());

        ajaxAuthGet('https://api.acecrouen.com/log/today',
            function (response) {
                $("#block-visits").text(response);
            },
            function (response) {
                $("#block-visits").text('error');
            });

        ajaxAuthGet('https://api.acecrouen.com/users/count',
            function (response) {
                $("#block-users").text(response);
            },
            function (response) {
                $("#block-users").text('error');
            });

        ajaxAuthGet('https://api.acecrouen.com/posts/count',
            function (response) {
                $("#block-posts").text(response);
            },
            function (response) {
                $("#block-posts").text('error');
            });

        // visitors count chart
        var end = new Date();
        var start = new Date((new Date()).setDate(end.getDate() - 14))
        start = formatDate(start);
        end = formatDate(end);
        console.log('http://localhost:8000/log/history?start=' + start + '&end=' + end);
        ajaxAuthGet('http://localhost:8000/log/history?start=' + start + '&end=' + end, function (response) {
            Morris.Area({
                element: 'visitor-chart',
                data: response,
                xkey: 'date',
                ykeys: ['count'],
                labels: ['Visitor'],
                pointSize: 2,
                hideHover: 'auto',
                resize: true
            });
        });
    });
});

function ajaxAuthGet(url, success, error) {
    return $.ajax({
        url: url,
        type: 'get',
        headers: {
            Authorization: auth
        },
        dataType: 'json',
        success: success,
        error: error
    });
}

function checkLogin() {
    return attempt(Cookies.get('Authorization'), function (response) {
        auth = Cookies.get('Authorization');
        $("#span-name").text(response.name);
    }, function () {
        window.location.replace("login.html");
    });
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
