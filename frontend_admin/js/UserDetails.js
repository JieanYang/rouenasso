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
        
        $.when(
            page(jugeUrl())
            ).done(function () {
            // hide loader
            $("#loader").removeClass("show");
        });
    });
});


function jugeUrl(){
    url = window.location.href;
    id = url.slice(url.indexOf('?')+8, url.indexOf('?')+9);
    operation = url.slice(url.indexOf('&')+1, url.indexOf('&')+5);
    return {"id": id, "operation": operation};
}

function page(obj){
    switch(obj.operation){
        case 'look':
            page_view(obj.id);
            break;
        case 'edit':
            page_edit(obj.id);
            break;
        default:
            console.log('bad request!');
    }
}


function page_view(id){
    $('#UserDetails_page .form_view').css('display', 'block');
    $('#UserDetails_page .form_edit').css('display', 'none');

    ajaxAuthGet('https://api.acecrouen.com/users/'+id,
        function (response){
            $('#UserDetails_page .form_view #name').text(response[0].name);
            $('#UserDetails_page .form_view #email').text(response[0].email);
            $('#UserDetails_page .form_view #school').text(response[0].school);
            $('#UserDetails_page .form_view #phone_number').text(response[0].phone_number);
            $('#UserDetails_page .form_view #department').text(response[0].department);
            $('#UserDetails_page .form_view #position').text(response[0].position);
            $('#UserDetails_page .form_view #isWorking').text(convert('isWorking', response[0].isWorking));
            $('#UserDetails_page .form_view #birthday').text(response[0].birthday);
            $('#UserDetails_page .form_view #arrive_date').text(response[0].arrive_date);
            $('#UserDetails_page .form_view #dimission_date').text(convert('dimission_date', response[0].dimission_date));

            var url = window.location.href;
            var n = url.indexOf('?');
            var prefix = url.slice(0,n+8);
            $('#editButton_form_view').on('click',function(){
                window.location.href=prefix+id+'&edit=true';
            });
            $('#returnButton_form_view').on('click',function(){
                window.location.href=url.slice(0,n).slice(0,-16)+'listOfUsers.html';
            });

            if(response[0].department == '项目开发部'){
                $('#editButton_form_view').css('display', 'none');
            }

        },
        function (response){
            console.log('访问失败');
        });
}

function page_edit(id){
    $('#UserDetails_page .form_view').css('display', 'noe');
    $('#UserDetails_page .form_edit').css('display', 'block');
    
    ajaxAuthGet('https://api.acecrouen.com/users/'+id,
        function (user){
            $('#UserDetails_page .form_edit input#name').val(user[0].name);
            $('#UserDetails_page .form_edit #email').val(user[0].email);
            $('#UserDetails_page .form_edit #school').val(user[0].school);
            $('#UserDetails_page .form_edit #phone_number').val(user[0].phone_number);
            $('#UserDetails_page .form_edit #department').val(convert('department', user[0].department));
            $('#UserDetails_page .form_edit #position').val(convert('position', user[0].position));
            $('#UserDetails_page .form_edit #isWorking').val(user[0].isWorking);
            $('#UserDetails_page .form_edit #birthday').val(user[0].birthday);
            $('#UserDetails_page .form_edit #arrive_date').val(user[0].arrive_date);
            $('#UserDetails_page .form_edit #dimission_date').val(user[0].dimission_date);
            // 返回按钮
            var url = window.location.href;
            var n = url.indexOf('?');
            var prefix = url.slice(0,n+8);
            $('#returnButton_form_edit').on('click',function(){
                window.location.href=prefix+id+'&look=true';
            });

            updateButton($('#updateButton_form_edit'), id);



        },
        function (response){
            console.log('访问失败');
        });
}

function updateButton(button, id){
    button.on('click', function(){
        var user_update = {};
        user_update.name = $('#UserDetails_page .form_edit input#name').val();
        user_update.email = $('#UserDetails_page .form_edit #email').val();
        user_update.school = $('#UserDetails_page .form_edit #school').val();
        user_update.phone_number = $('#UserDetails_page .form_edit #phone_number').val();
        user_update.department = $('#UserDetails_page .form_edit #department').val();
        user_update.position = $('#UserDetails_page .form_edit #position').val();
        user_update.isWorking = $('#UserDetails_page .form_edit #isWorking').val();
        user_update.birthday = $('#UserDetails_page .form_edit #birthday').val();
        user_update.arrive_date = $('#UserDetails_page .form_edit #arrive_date').val();
        user_update.dimission_date = $('#UserDetails_page .form_edit #dimission_date').val();

        ajaxAuthPut('http://localhost:8000/users/'+id, user_update,
            function(response){
                var text = JSON.stringify(response);
                $('#response_update').text(text).css('font-size', '1.2em');
            },function(response){
                console.log(response);
            });
        
    });
}


function convert (str, index){
    switch(str){
        case 'department':
            switch(index){
                case '主席团': return 'ZHUXITUAN'; break;
                case '组织部': return 'ZUZHIBU'; break;
                case '宣传部': return 'XUANCHUANBU'; break;
                case '外联部': return 'WAILIANBU'; break;
                case '秘书部': return 'MISHUBU'; break;
                case '安全部': return 'ANQUANBU'; break;
                default: return 'choice_department';
            } break;
        case 'position':
            switch(index){
                case '主席': return 'ZHUXI'; break;
                case '副主席': return 'FUZHUXI'; break;
                case '部长': return 'BUZHANG'; break;
                case '副部长': return 'FUBUZHANG'; break;
                case '成员': return 'CHENGYUAN'; break;
                default: return 'choice_position';
            } break;
        case 'isWorking':
            switch(index){
                case 1: return '在职'; break;
                case 0: return '离任'; break;
            } break;
        case 'dimission_date':
            switch(index){
                    case null: return '在任'; break;
                    default:
                        return response[0].dimission_date;
                } break;
        default:
            console.log('bad request!');
    }
}

