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


function ajaxLeavemessage() {
  ajaxAuthGet('http://localhost:8000/leaveMessages',
    function(response){

      var leaveMessages_obj = $('#panel_leavemessage');

      $.each(response, function(index, item){
        var leaveMessages_item = $('<div>', {class: 'item_leavemessage', style: 'border:1px solid gray; padding: 6px; margin-bottom: 15px;'});
        leaveMessages_item.append($('<h4>', {html: item.name_leaveMessage}));
        leaveMessages_item.append($('<p>', {html: item.message_leaveMessage}));
        show_contactWay(item, leaveMessages_item);
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
// function ajaxPostsTable() {
//     ajaxAuthGet('https://api.acecrouen.com/posts/calendar/show',
//         function (response) {
//             console.log(response);

//             var table_obj = $('#postsTables');

//             $.each(response, function(index, item){
//                  var table_row = $('<tr>', {id: 'table-row-post-id-' + item.id, 'data-url': item.url});
//                  table_row.append($('<td>', {html: categoryIdToName(item.category)}));
//                  table_row.append($('<td>', {html: item.title}));
//                  table_row.append($('<td>', {html: item.created_at}));
//                  table_row.append($('<td>', {html: item.published_at == null ? '草稿' : item.published_at}));
//                  table_obj.append(table_row);
//             });

//             responsiveTable();
//         },
//         function (response) {
//             $('#postsTables').after('error').remove();
//         });
// }

// function responsiveTable() {
//     $('#postsTables').DataTable({
//         //responsive: true,
//         bAutoWidth: true,
//         columnDefs: [{
//            targets: 1,
//            render: function(data, type, full, meta){
//               if(type === 'display'){
//                  data = data + '<div class="links">' +
//                      '<a href="#" class="btn-view">查看</a> ' +
//                      '<a href="#" class="btn-edit">修改</a> ' +
//                      '<a href="#" class="btn-delete">删除</a> ' +
//                      '</div>';                     
//               }
               
//               return data;
//            }
//         }]
//     });

//     // view buttons
//     $(".btn-view").on('click', function () {
//         var postId = $(this).parent().parent().parent().attr('id').split('-')[4];
//         alert('前端文章浏览页面 + id = ' + postId);
//         window.location.href = "//";
//     });

//     // edit buttons
//     $(".btn-edit").on('click', function () {
//         var postId = $(this).parent().parent().parent().attr('id').split('-')[4];
//         var postUrl = $(this).parent().parent().parent().attr('data-url');
//         window.open('./post/edit.html?id=' + postId + '&url=' + postUrl);
//     });

//     // delete buttons
//     $(".btn-delete").on('click', function () {
//         var postId = $(this).parent().parent().parent().attr('id').split('-')[4];

// 		function success(result) {
// 		    $("#table-row-post-id-" + postId).remove();
// 		}

// 		function error(result) {
// 		    console.log(result);
// 		    alert("你无权限删除文章。");
// 		}

//         ajaxAuthDelete('https://api.acecrouen.com/posts/' + postId, null, success, error);
//     });
// }
