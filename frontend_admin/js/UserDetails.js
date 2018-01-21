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
            console.log(response);
            $('#UserDetails_page .form_view #name').text(response[0].name);
            $('#UserDetails_page .form_view #email').text(response[0].email);
            $('#UserDetails_page .form_view #school').text(response[0].school);
            $('#UserDetails_page .form_view #phone_number').text(response[0].phone_number);
            $('#UserDetails_page .form_view #department').text(response[0].department);
            $('#UserDetails_page .form_view #position').text(response[0].position);
            $('#UserDetails_page .form_view #isWorking').text(
                function(){
                    switch(response[0].isWorking){
                        case 1:
                            return '在职';
                            break;
                        case 0:
                            return '离任';
                            break;
                    }
                });
            $('#UserDetails_page .form_view #birthday').text(response[0].birthday);
            $('#UserDetails_page .form_view #arrive_date').text(response[0].arrive_date);
            $('#UserDetails_page .form_view #dimission_date').text(
                function(){
                    switch(response[0].dimission_date){
                        case null:
                            return '在任';
                            break;
                        default:
                            return response[0].dimission_date;
                    }
                });
            var url = window.location.href;
            var n = url.indexOf('?');
            var prefix = url.slice(0,n+8);
            $('#editButton_form_view').on('click',function(){
                window.location.href=prefix+id+'&edit=true';
            });

        },
        function (response){
            console.log('访问失败');
        });
}

function page_edit(id){
    $('#UserDetails_page .form_view').css('display', 'noe');
    $('#UserDetails_page .form_edit').css('display', 'block');
    
}