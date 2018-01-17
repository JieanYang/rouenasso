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

        // category select options
        $.each(categoryMap, function (id, name) {
            $('#post-category').append($('<option>', {
                value: id,
                text: name
            }));
        });
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
    ajaxAuthGet('https://api.acecrouen.com/posts/calendar/show',
        function (response) {
            // console.log(response);

            var table_obj = $('#postsTables');

            $.each(response, function (index, item) {
                var table_row = $('<tr>', {
                    id: 'table-row-post-id-' + item.id + '-category-' + item.category
                    //, 'data-url': item.url
                });
                table_row.append($('<td>', {
                    html: categoryIdToName(item.category)
                }));
                table_row.append($('<td>', {
                    html: item.title
                }));
                table_row.append($('<td>', {
                    html: item.created_at
                }));
                table_row.append($('<td>', {
                    html: item.published_at == null ? '草稿' : item.published_at
                }));
                table_obj.append(table_row);
            });

            responsiveTable();
        },
        function (response) {
            $('#postsTables').after('error').remove();
        });
}

function responsiveTable() {
    $('#postsTables').DataTable({
        //responsive: true,
        bAutoWidth: true,
        order: [[3,'desc'],[2,'desc']],
        columnDefs: [{
            targets: 1,
            render: function (data, type, full, meta) {
                if (type === 'display') {
                    data = data + '<div class="links">' +
                        '<a href="#" class="btn-view">查看</a> ' +
                        '<a href="#" class="btn-edit">修改</a> ' +
                        '<a href="#" class="btn-delete">删除</a> ' +
                        '</div>';
                }

                return data;
            }
        }]
    });


    function initTableButtons() {
        // view buttons
        $(".btn-view").on('click', function () {
            var postId = $(this).parent().parent().parent().attr('id').split('-')[4];
            var postCategory = $(this).parent().parent().parent().attr('id').split('-')[6];
            var url = "";
            switch (postCategory) {
                case '1':
                    url = "https://www.acecrouen.com/home/movements/" + postId;
                    break;
                case '3':
                    url = "https://www.acecrouen.com/home/works/" + postId;
                    break;
                case '4':
                    url = "https://www.acecrouen.com/home/writing/" + postId;
                    break;
                case '99':
                    url = "https://www.acecrouen.com/";
                    break;
                default:
                    // console.log('category error : category = ' + postCategory);
                    break;
            }
            window.open(url);
        });

        // edit buttons
        $(".btn-edit").on('click', function () {
            var postId = $(this).parent().parent().parent().attr('id').split('-')[4];
            // var postUrl = $(this).parent().parent().parent().attr('data-url');
            window.open('./post/edit.html?id=' + postId + '&url=https://api.acecrouen.com/posts/' + postId);
        });

        // delete buttons
        $(".btn-delete").on('click', function () {
            var postId = $(this).parent().parent().parent().attr('id').split('-')[4];

            function success(result) {
                $("#table-row-post-id-" + postId).remove();
            }

            function error(result) {
                // console.log(result);
                alert("你无权限删除文章。");
            }

            ajaxAuthDelete('https://api.acecrouen.com/posts/' + postId, null, success, error);
        });
    }

    initTableButtons();
    $('#postsTables').on('draw.dt', function () {
        initTableButtons();
    });
}
