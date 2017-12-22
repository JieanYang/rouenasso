var auth = null;
var user_id = null;
var post = null; // input post
var category = null;
var isNewPost = true;
var ue = null; // neditor
var uploadImageUrl = "";

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
            ajaxGetOnePost() // 获取文章
        ).done(function () {
            // 加载富文本编辑器
            ue = UE.getEditor('editor');
            ue.ready(function () {
                // 设置自动宽度
                $("#edui1").css('width', '100%');
                $("#edui1_iframeholder").css('width', '100%');

                if (!isNewPost) {
                    ue.setContent(post.html_content);
                }

                initFields();

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
    $("#post-category").prop('disabled', enable);
    $(".preview-input").prop('disabled', enable);
}

function paramError() {
    $("#wrapper").html("<h1>参数错误</h1>")
    setTimeout(
        function () {
            window.close();
        }, 1500);
}

// ajax - 检查登陆，参数，权限
function checkLogin() {

    return attempt(Cookies.get('Authorization'), function (response) {
        auth = Cookies.get('Authorization');
        setAuthCookie(auth);
        user_id = response.id;

        // check params
        if (!getParameterByName('url')) {
            paramError();
        } else if (getParameterByName('url') == 'new') {
            if (!getParameterByName('category')) {
                paramError();
            }
        } else if (getParameterByName('url') != 'new') {
            if (!getParameterByName('id')) {
                paramError();
            }
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
function ajaxGetOnePost() {
    if (isNewPost) {
        category = getParameterByName('category');
        return true;
    }
    return ajaxAuthGet(getParameterByName('url'),
        function (response) {
            post = response;
            category = post.category.toString();
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
            category: category,
            html_content: ue.getContent(),
            preview_text: generatePreviewString()
        };
        $.when(uploadImage()).done(function () {
            postData.preview_img_url = uploadImageUrl;
            console.log("draft - new");
            console.log(postData);
            return ajaxAuthPost('https://api.acecrouen.com/posts/', postData,
                function (response) {
                    // reload, with id and url
                    window.location.replace("?id=" + response.id + "&url=" + response.url);
                },
                function (response) {
                    alert('error');
                    console.log(response);
                });
        });
    } else if (!post.published_at) { // 修改草稿

        // disable all, show loader
        disableInputs(true);
        ue.setDisabled('fullscreen');
        $("#loader").addClass("show");

        postData = post;
        postData.title = $("#post-title").val();
        postData.category = category;
        postData.html_content = ue.getContent();
        postData.preview_text = generatePreviewString();
        delete postData.published_at; // value is null, remove this, else validator will say it is not a date format.

        $.when(uploadImage()).done(function () {
            postData.preview_img_url = uploadImageUrl;
            console.log("draft - old");
            console.log(postData);
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
        });
    } else {
        alert("已发布文章无法保存为草稿。");
    }
}

// ajax - Publish Post
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
            category: category,
            html_content: ue.getContent(),
            published_at: formatDateTime(new Date()),
            preview_text: generatePreviewString()
        };
        $.when(uploadImage()).done(function () {
            postData.preview_img_url = uploadImageUrl;
            console.log("publish - new");
            console.log(postData);
            return ajaxAuthPost('https://api.acecrouen.com/posts/', postData,
                function (response) {
                    // reload, with id and url
                    window.location.replace("?id=" + response.id + "&url=" + response.url);
                },
                function (response) {
                    alert('error');
                    console.log(response);
                });
        });
    } else {
        postData = post;
        postData.title = $("#post-title").val();
        postData.category = category;
        postData.html_content = ue.getContent();
        postData.published_at = formatDateTime(new Date());
        postData.preview_text = generatePreviewString();

        $.when(uploadImage()).done(function () {
            postData.preview_img_url = uploadImageUrl;
            console.log("publish - old");
            console.log(postData);
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
        });
    }
}

// category special preview helper
function generatePreviewString() {
    var jsonObj = null;
    switch (category) {
        case '1': // 活动推广
            jsonObj = {
                "introduction": $("#preview-activity-introduction").val()
            };
            break;
        case '3': // 工作咨询
            jsonObj = {
                "title": $("#preview-job-title").val(),
                "company": $("#preview-job-company").val(),
                "city": $("#preview-job-city").val(),
                "salary": $("#preview-job-salary").val()
            };
            break;
        case '4': // 生活随笔
            jsonObj = {
                "username": $("#preview-writing-username").val(),
                "introduction": $("#preview-writing-introduction").val()
            };
            break;
        case '99':
            jsonObj = "showing";
            break;
        default:
            paramError();
            break;
    }

    if (category == '99') {
        return jsonObj;
    }
    else {
        return JSON.stringify(jsonObj);
    }
}

function initFields() {
    if (!isNewPost) {
        $("#post-title").val(post.title);
        if (post.category == 99) {
            jsonPreviewTextObj = post.preview_text;
        } else {
            jsonPreviewTextObj = JSON.parse(post.preview_text);
        }
    }

    switch (category) {
        case '1': // 活动推广
            $("#category-preview-inputs").html(`
                <div class="col-lg-8">
                    <label>简介</label>
                    <input id="preview-activity-introduction" class="form-control preview-input" />
                </div>
            `);
            if (!isNewPost) {
                $("#preview-activity-introduction").val(jsonPreviewTextObj.introduction);
            }
            break;
        case '3': // 工作咨询
            $("#category-preview-inputs").html(`
                <div class="col-sm-3">
                    <label>职位</label>
                    <input id="preview-job-title" class="form-control preview-input" />
                </div>
                <div class="col-sm-3">
                    <label>公司</label>
                    <input id="preview-job-company" class="form-control preview-input" />
                </div>
                <div class="col-sm-3">
                    <label>工作城市</label>
                    <input id="preview-job-city" class="form-control preview-input" />
                </div>
                <div class="col-sm-3">
                    <label>工资</label>
                    <input id="preview-job-salary" class="form-control preview-input" />
                </div>
            `);
            if (!isNewPost) {
                $("#preview-job-title").val(jsonPreviewTextObj.title);
                $("#preview-job-company").val(jsonPreviewTextObj.company);
                $("#preview-job-city").val(jsonPreviewTextObj.city);
                $("#preview-job-salary").val(jsonPreviewTextObj.salary);
            }
            $("#post-preview-image").hide();
            break;
        case '4': // 生活随笔
            $("#category-preview-inputs").html(`
                <div class="col-sm-4">
                    <label>作者</label>
                    <input id="preview-writing-username" class="form-control preview-input" />
                </div>
                <div class="col-sm-8">
                    <label>简介</label>
                    <input id="preview-writing-introduction" class="form-control preview-input" />
                </div>
            `);
            if (!isNewPost) {
                $("#preview-writing-username").val(jsonPreviewTextObj.username);
                $("#preview-writing-introduction").val(jsonPreviewTextObj.introduction);
            }
            break;
        case '99':
            $("#post-preview-image").hide();
            break;
        default:
            alert('in');
            paramError();
            break;
    }

    if (!isNewPost && post.preview_img_url) {
        $("#post-preview-image-preview-div").html("<img id='post-preview-image-image' src='" + post.preview_img_url + "' alt='preview image' height='50px' width='auto' />");
    }
}

// upload image
function uploadImage() {
    // upload image
    if ($("#post-preview-image").val()) {
        var file_data = $('#post-preview-image').prop('files')[0];
        var data = new FormData();
        data.append('preview_img', file_data);
        console.log(data);
        return $.ajax({
            type: 'POST',
            url: "https://api.acecrouen.com/uploadimg",
            data: data,
            headers: {
                Authorization: auth
            },
            cache: false,
            contentType: false,
            processData: false, // must be false if there is image
            success: function (response) {
                console.log(response);
                uploadImageUrl = response.path;
                if ($('#post-preview-image-image').length) { // if img exists
                    $("#post-preview-image-image").attr("src", response.path);
                } else { // if not exist, append
                    $("#post-preview-image-preview-div").html("<img id='post-preview-image-image' src='" + uploadImageUrl + "' alt='preview image' height='50px' width='auto' />");
                }

            },
            error: function (response) {
                alert('error');
                console.log(response);
                uploadImageUrl = "";
            }
        });
    } else {
        return true;
    }
}
