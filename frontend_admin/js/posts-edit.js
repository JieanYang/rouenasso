var auth = null;
var user_id = null;
var post = null; // input post
var isNewPost = true;
var ue = null; // neditor

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

    disableInputs(true);

    // login check
    $.when(checkLogin()).done(function () {
        $.when(
            ajaxGetPost() // 获取文章
        ).done(function () {
            // 加载富文本编辑器
            ue = UE.getEditor('editor');
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
                if (!isNewPost) {
                    if (post.published_at) {
                        $("#btn-save-draft").css('display', 'none');
                    }
                }
                $("#btn-save-draft").on('click', function () {
                    ajaxSaveDraft();
                });
                $("#btn-publish").on('click', function () {
                    ajaxPublishPost();
                });

                // select options
                $.each(categoryMap, function (id, name) {
                    $('#post-category').append($('<option>', {
                        value: id,
                        text: name
                    }));
                });

                // seleted option
                if (!isNewPost) {
                    $('#post-category').val(post.category);
                }

                disableInputs(false);

                // 隐藏loader
                $("#loader").removeClass("show");
            });
        });
    });
});

// enable / disable inputs
function disableInputs(enable) {
    $("#btn-save-draft").prop('disabled', enable);
    $("#btn-publish").prop('disabled', enable);
    $("#post-title").prop('disabled', enable);
    $('#post-category').prop('disabled', enable);
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
                }, 300000);
        });
}

// ajax - save draft
function ajaxSaveDraft() {
    if (!($("#post-title").val() && ue.hasContents())) {
        alert("必须填写标题和内容");
        return;
    }
    if (isNewPost) { // 新草稿
        // disable all, show loader
        disableInputs(true);
        ue.setDisabled('fullscreen');
        $("#loader").addClass("show");

        postData = {
            title: $("#post-title").val(),
            user_id: user_id,
            category: $("#post-category").val(),
            html_content: ue.getContent()
        };

        return ajaxAuthPost('https://api.acecrouen.com/posts/', postData,
            function (response) {
                // reload, with id and url
                window.location.replace("?id=" + response.id + "&url=" + response.url);
            },
            function (response) {
                alert('error');
                console.log(response);
            });
    } else if (!post.published_at) { // 修改草稿

        // disable all, show loader
        disableInputs(true);
        ue.setDisabled('fullscreen');
        $("#loader").addClass("show");

        postData = post;
        postData.title = $("#post-title").val();
        postData.category = $("#post-category").val();
        postData.html_content = ue.getContent();
        delete postData.published_at; // value is null, remove this, else validator will say it is not a date format.

        return ajaxAuthPut('https://api.acecrouen.com/posts/' + post.id, postData,
            function (response) {
                // enable all, hide loader
                disableInputs(false);
                ue.setEnabled();
                $("#loader").removeClass("show");
            },
            function (response) {
                alert('error');
                console.log(response);
            });
    } else {
        alert("已发布文章无法保存为草稿。");
    }
}

// ajax - save draft
function ajaxPublishPost() {
    if (!($("#post-title").val() && ue.hasContents())) {
        alert("必须填写标题和内容");
        return;
    }

    // disable all, show loader
    disableInputs(true);
    ue.setDisabled('fullscreen');
    $("#loader").addClass("show");

    if (isNewPost) {
        postData = {
            title: $("#post-title").val(),
            user_id: user_id,
            category: $("#post-category").val(),
            html_content: ue.getContent(),
            published_at: formatDateTime(new Date())
        };

        return ajaxAuthPost('https://api.acecrouen.com/posts/', postData,
            function (response) {
                // reload, with id and url
                window.location.replace("?id=" + response.id + "&url=" + response.url);
            },
            function (response) {
                alert('error');
                console.log(response);
            });
    } else {
        postData = post;
        postData.title = $("#post-title").val();
        postData.category = $("#post-category").val();
        postData.html_content = ue.getContent();
        postData.published_at = formatDateTime(new Date());

        return ajaxAuthPut('https://api.acecrouen.com/posts/' + post.id, postData,
            function (response) {
                // enable all, hide loader
                disableInputs(false);
                ue.setEnabled();
                $("#loader").removeClass("show");
            },
            function (response) {
                alert('error');
                console.log(response);
            });
    }
}
