var auth = null;
var user_id = null;
var post = null;
var isNewPost = true;

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

    disableButtons(true);

    // login check
    $.when(checkLogin()).done(function () {
        $.when(
            ajaxGetPost() // 获取文章
        ).done(function () {
            // 加载富文本编辑器
            var ue = UE.getEditor('editor');
            ue.ready(function () {
                // 设置自动宽度
                $("#edui1").css('width', '100%');
                $("#edui1_iframeholder").css('width', '100%');

                if (!isNewPost) {
                    // 读取标题
                    $("#post-title").val(post.title);
                    //读取内容
                    ue.setContent(post.html_content);
                    // 预览内容
                    $("#preview").html(ue.getContent());
                    $("#preview-title").text(post.title);
                }

                // 实时预览内容
                $("#post-title").on('change', function () {
                    $("#preview-title").text($(this).val());
                });
                ue.addListener('contentChange', function (editor) {
                    $("#preview").html(ue.getContent());
                });

                // buttons
                $("#btn-save-draft").on('click', function () {
                    alert(4);
                });
                $("#btn-publish").on('click', function () {
                    alert(5);
                });

                disableButtons(false);

                // 隐藏loader
                $("#loader").removeClass("show");
            });
        });
    });
});

// enable / disable save draft btn and publish btn
function disableButtons(enable) {
    $("#btn-save-draft").prop('disabled', enable);
    $("#btn-publish").prop('disabled', enable);
}

// ajax - 检查登陆，参数，权限
function checkLogin() {
    return attempt(Cookies.get('Authorization'), function (response) {
        auth = Cookies.get('Authorization');
        setAuthCookie(auth);
        user_id = response.id;

        // check params
        if (!(getParameterByName('id') && getParameterByName('url'))) {
            $("#wrapper").html("<h1>参数错误</h1>")
            setTimeout(
                function () {
                    window.close();
                }, 1500);
        }

        // 新增内容 => 主席团&宣传部
        // 修改草稿 => 主席团&宣传部
        // 删除内容 => 主席团&宣传部部长&宣传部副部长
        // 删除草稿 => 主席团&宣传部
        dept = response.department;
        if (!(dept == '主席团' || dept == '宣传部' || dept == '项目开发部')) {
            $("#wrapper").html("<h1>无权限修改此内容</h1>")
            setTimeout(
                function () {
                    window.close();
                }, 1500);
        }

        isNewPost = getParameterByName('url') == 'new' ? true : false;

    }, function () {
        window.location.replace("../login.html");
    });
}

// ajax - get post object
function ajaxGetPost() {
    if (isNewPost) {
        return true;
    }
    return ajaxAuthGet(getParameterByName('url'),
        function (response) {
            post = response;
        },
        function () {
            $("#wrapper").html("<h1>无法获取文章</h1>")
            setTimeout(
                function () {
                    window.close();
                }, 3000);
        });
}

// ajax - save draft
function ajaxSaveDraft() {
    if (isNewPost) {
        postData = {
            title: $("#post-title").val();
            user_id: auth
            category: ("#post-category").val();
            html_content: ue.getContent();
            published_at: null
        };
        return ajaxAuthPost('https://api.acecrouen.com/post/', postData,
            function (response) {
                console.log(response);
            },
            function (response) {
                console.log(response);
            });
    } else {
        postData = post;
        postData.title = $("#post-title").val();
        postData.category = ("#post-category").val();
        postData.html_content = ue.getContent();
        postData.published_at = null;

        return ajaxAuthPut('https://api.acecrouen.com/post/' + post.id, postData,
            function (response) {
                console.log(response);
            },
            function (response) {
                console.log(response);
            });
    }
}
