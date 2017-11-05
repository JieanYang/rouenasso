var categoryMap = null;

$(window).on('load', function () {
    $.getJSON("/json/category-map.json", function (json) {
        categoryMap = json;
    });
});

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

// base ajax get with auth
function ajaxAuthGet(url, success, error) {
    return $.ajax({
        url: url,
        type: 'get',
        headers: {
            Authorization: auth
        },
        dataType: 'json',
        success: success,
        error: error
    });
}

// base ajax post with auth
function ajaxAuthPost(url, data, success, error) {
    return $.ajax({
        url: url,
        type: 'post',
        headers: {
            Authorization: auth
        },
        data: data,
        dataType: 'json',
        success: success,
        error: error
    });
}

// base ajax post with auth
function ajaxAuthPut(url, data, success, error) {
    return $.ajax({
        url: url,
        type: 'put',
        headers: {
            Authorization: auth
        },
        data: data,
        dataType: 'json',
        success: success,
        error: error
    });
}

// categoryMap
function categoryIdToName(id) {
    return categoryMap[id];
}

function categoryNameToId(name) {
    _.findKey(categoryMap, name);
}

function listCategoryName() {
    names = [];
    $.each(categoryMap, function(i, val) {
      names.push(val);
    });
    return names;
}
