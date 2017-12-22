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
      $category_delete = $('#TrashCans-category').val();
      if ($category_delete == 'posts_deletete')
        $load_function = ajaxPostsTable;
      else if($category_delete == 'leaveMessages_delete')
        $load_function = null;
        $.when($load_function()).done(function () {
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
    ajaxAuthGet('https://api.acecrouen.com/TrashCans',
        function (response) {
            // console.log(response);

            var table_obj = $('#postsTables_delete');

            $.each(response, function(index, item){
                 var table_row = $('<tr>', {id: 'table-row-post-id-' + item.id, 'data-url': item.url});
                 table_row.append($('<td>', {html: categoryIdToName(item.category)}));
                 table_row.append($('<td>', {html: item.title}));
                 table_row.append($('<td>', {html: item.created_at}));
                 table_row.append($('<td>', {html: item.published_at == null ? '草稿' : item.published_at}));
                 table_row.append($('<td>', {html: item.deleted_at}));
                 table_obj.append(table_row);
            });

            responsivePostDeleteTable();
        },
        function (response) {
            $('#postsTables_delete').after('error').remove();
        });
}

function responsivePostDeleteTable() {
    $('#postsTables_delete').DataTable({
        responsive: true,
        bAutoWidth: true,
        columnDefs: [{
           targets: 1,
           render: function(data, type, full, meta){
              if(type === 'display'){
                 data = data + '<div class="links">' +
                     '<a href="#" class="btn-view">查看</a> ' +
                     '<a href="#" class="btn-restore">恢复</a> ' +
                     '<a href="#" class="btn-forceDelete">永久删除</a> ' +
                     '</div>';                     
              }
               
              return data;
           }
        }]
    });

    // view buttons
    $(".btn-view").on('click', function () {
        var postId = $(this).parent().parent().parent().attr('id').split('-')[4];
        // alert('前端文章浏览页面 + id = ' + postId);
        // window.location.href = "posts_delete_detail.html?id="+postId;
        ajaxAuthGet('http://localhost:8000/TrashCans/'+postId,function(response){
          console.log(response);
          if (response.status == 404 ){
            $('#model_view h3').text('错误');
            $('#model_view').children('p').last().text(response.msg+'!');
          }else if (response.id){
            $('#model_view h3').text(response.title);
            $('#model_view').children('p').last().html(response.html_content);
          }
          $('.fullbg').addClass('show');
          $('#model_view').addClass('show');
        },function(response){
          alert('错误！');
        });
    });

    // restore buttons
    $(".btn-restore").on('click', function () {
        var postId = $(this).parent().parent().parent().attr('id').split('-')[4];
        // var postUrl = $(this).parent().parent().parent().attr('data-url');
        // window.open('./post/edit.html?id=' + postId + '&url=' + postUrl);
        function success_restore(result){
          if (result.status == 404 ){
            $('#model_view h3').text('错误');
            $('#model_view').children('p').last().text(result.msg+'!');
          }else if (result.status == 200){
            $('#model_view h3').text('恢复成功');
            $('#model_view').children('p').last().html(result.msg+'!');
          }
          $("#table-row-post-id-" + postId).remove();
          $('.fullbg').addClass('show');
          $('#model_view').addClass('show');
        }
        function error_restore(result){
          alert('错误！');
        }
        ajaxAuthPut('http://localhost:8000/TrashCans/'+postId, null, success_restore, error_restore);
    });

    // delete buttons
    $(".btn-forceDelete").on('click', function () {
        var postId = $(this).parent().parent().parent().attr('id').split('-')[4];

    function success(result) {
      if(result.status == 403){
        $('#model_view h3').text('身份');
        $('#model_view').children('p').last().text(result.msg+'!');
      }else if (result.status == 404 ){
        $('#model_view h3').text('错误');
        $('#model_view').children('p').last().text(result.msg+'!');
      }else if (result.status == 200){
        $('#model_view h3').text('数据库删除');
        $('#model_view').children('p').last().html(result.msg+'!');
      }
      $("#table-row-post-id-" + postId).remove();
      $('.fullbg').addClass('show');
      $('#model_view').addClass('show');
    }

    function error(result) {
        console.log(result);
        alert("你无权限删除文章。");
    }

        ajaxAuthDelete('http://localhost:8000/TrashCans/'+postId, null, success, error);
    });
}


function closeModelView() {
  $('.fullbg').removeClass('show');
  $('#model_view').removeClass('show');
}