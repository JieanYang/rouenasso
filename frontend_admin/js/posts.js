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
        $.when(ajaxPostsTable()).done(function () {
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
function ajaxPostsTable() {
    ajaxAuthGet('http://localhost:8000/posts/calendar/show?local=true',
        function (response) {
            console.log(response);
        
            var table_obj = $('#postsTables');
        
            $.each(response, function(index, item){
                 var table_row = $('<tr>', {id: 'table-row-post-id-' + item.id, 'data-url': item.url});
                 table_row.append($('<td>', {html: categoryIdToName(item.category)}));
                 table_row.append($('<td>', {html: item.title}));
                 table_row.append($('<td>', {html: item.created_at}));
                 table_row.append($('<td>', {html: item.published_at == null ? '草稿' : item.published_at}));
                 table_row.append($('<td>', {html: '<i class="fa fa-eye fa-2x btn-view" aria-hidden="true"></i>'}));
                 table_row.append($('<td>', {html: '<i class="fa fa-pencil fa-2x btn-edit" aria-hidden="true"></i>'}));
                 table_row.append($('<td>', {html: '<i class="fa fa-trash fa-2x btn-delete" aria-hidden="true"></i>'}));
                 table_obj.append(table_row);
            });
        
            // view buttons
            $(".btn-view").on('click', function () {
                var postId = $(this).parent().parent().attr('id').split('-')[4];
                alert('前端文章浏览页面 + id = ' + postId);
                window.location.href = "//";
            });
        
            // edit buttons
            $(".btn-edit").on('click', function () {
                var postId = $(this).parent().parent().attr('id').split('-')[4];
                var postUrl = $(this).parent().parent().attr('data-url');
                window.open('./post/edit.html?id=' + postId + '&url=' + postUrl);
            });
        
            responsiveTable();
        },
        function (response) {
            $('#postsTables').after('error').remove();
        });
}

function responsiveTable() {
    $('#postsTables').DataTable({
        responsive: true,
        bAutoWidth: true
    });
}