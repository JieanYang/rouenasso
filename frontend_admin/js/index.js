var auth = null;

$(window).on('load', function () {
    // show loader
    $("#loader").addClass("show");

    // smooth anchor scroll
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 750);
    });

    // logout btn
    $("#btn-logout").click(function () {
        logout();
    });

    // login check
    $.when(checkLogin()).done(function () {
        // dashboard
        $("#block-date").text((new Date).toLocaleDateString());
        $("#block-time").text((new Date).toLocaleTimeString());

        $.when(ajaxBlockVisitors(), // dashboard
            ajaxBlockUsers(), // dashboard
            ajaxBlockPosts(), // dashboard
            ajaxVisitorsChart(), // chart
            ajaxCalendar() // calendar
        ).done(function () {
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

// ajax dashboard bolcks
function ajaxBlockVisitors() {
    return ajaxAuthGet('https://api.acecrouen.com/log/today',
        function (response) {
            $("#block-visits").text(response);
        },
        function (response) {
            $("#block-visits").text('error');
        });
}

function ajaxBlockUsers() {
    return ajaxAuthGet('https://api.acecrouen.com/users/count/show',
        function (response) {
            $("#block-users").text(response);
        },
        function (response) {
            $("#block-users").text('error');
        });
}

function ajaxBlockPosts() {
    return ajaxAuthGet('https://api.acecrouen.com/posts/count/show',
        function (response) {
            $("#block-posts").text(response);
        },
        function (response) {
            $("#block-posts").text('error');
        });
}




// ajax - visitors count chart
function ajaxVisitorsChart() {
    var end = new Date();
    var start = new Date((new Date()).setDate(end.getDate() - 14))
    start = formatDate(start);
    end = formatDate(end);
    return ajaxAuthGet('https://api.acecrouen.com/log/history?start=' + start + '&end=' + end, function (response) {
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
}




// ajax - full calendar
function ajaxCalendar() {
    ajaxAuthGet('https://api.acecrouen.com/posts/calendar/show',
        function (response) {
            $('#calendar').fullCalendar({
                eventClick: function(event) {
                    if (event.url) {
                        alert('前端文章浏览页面 + id = ' + event.id);
                        window.open('//' + id);
                        return false;
                    }
                },
                events: response
            });
        },
        function (response) {
            $('#calendar').text('error');
        });
}






// base ajax get with auth
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

// format a date obj to yyyy-mm-dd string
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
