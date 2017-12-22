var auth = null;
var announcement = null;

$(window).on('load', function () {
    // show loader
    $("#loader").addClass("show");

    // navigation
    importLeftNavigation();
    
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
            ajaxBlockPosts() // dashboard
        ).done(function () {
            // hide loader
            //$("#loader").removeClass("show");
        });
        $.when(ajaxVisitorsChart()).done(function () {
            // hide loader
            $("#visitor-chart-loader").hide();
        });
        $.when(ajaxCalendar()).done(function () {
            // hide loader
            $("#calendar-loader").hide();
        });
        $.when(ajaxAnnouncement()).done(function () {
            // hide loader
            $("#announcement-loader").hide();
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
                eventClick: function (event) {
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


// ajax - announcement
function ajaxAnnouncement() {
    ajaxAuthGet('https://api.acecrouen.com/posts/category/99?latest=true',
        function (response) {
            announcement = response;
            $("#announcement").html(response.html_content);
            if (response.preview_text == "showing") {
                $("#show-or-hide-announcement").text("隐藏公告");
            } else {
                $("#show-or-hide-announcement").text("显示公告");
            }
            $("#show-or-hide-announcement").on('click', function () {
                $("#show-or-hide-announcement").prop("disabled", true);
                ajaxShowHideAnnouncement();
            });
            $("#show-or-hide-announcement").prop("disabled", false);
        },
        function (respinse) {

        })
}

function ajaxShowHideAnnouncement() {
    if (announcement.preview_text == 'showing') {
        announcement.preview_text = 'hiding';
    } else {
        announcement.preview_text = 'showing';
    }
    ajaxAuthPut('https://api.acecrouen.com/posts/' + announcement.id, announcement,
        function (response) {
            if (announcement.preview_text == 'showing') {
                $("#show-or-hide-announcement").text("隐藏公告");
            } else {
                $("#show-or-hide-announcement").text("显示公告");
            }
            $("#show-or-hide-announcement").prop("disabled", false);
        },
        function (response) {
            alert("error");
        });
}
