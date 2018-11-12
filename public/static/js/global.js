var ping = 0;

function layer_tip(msg, btn) {
    var btn = typeof(btn) == 'undefined' ? '确定' : btn;
    layer.open({
        content: msg,
        btn: btn
    })
}

function layer_tip_mini(msg, cb) {
    layer.open({
        content: msg
        , skin: 'msg'
    });
    if (typeof(cb) == 'function') {
        cb();
    }
}

var confirm = function (msg, cb) {
    //询问框
    return layer.confirm(msg, {
        btn: ['确定', '取消'] //按钮
    }, function () {
        if (typeof (cb) == 'function') {
            cb();
        }
    }, function () {
        layer.close();
    });
}

function alert_mini(msg, cb) {
    layer.msg(msg);
    if (typeof(cb) == 'function') {
        cb();
    }
}

var alert = function () {
    content = '';
    if (arguments[0]) {
        content = typeof(arguments[0]) == 'undefined' ? '提示消息' : arguments[0];
    }
    layer.open({
        title: [
            '信息提示',
            'background-color: #337AB7; color:#fff;'
        ],
        content: content,
        skin: 'ci-with-module'
    });
}

function ArrayDel(arr, index) {
    if (isNaN(index) || index >= arr.length) {
        return false;
    }
    for (var i = 0, n = 0; i < arr.length; i++) {
        if (arr[i] != arr[index]) {
            arr[n++] = arr[i];
        }
    }
    arr.length -= 1;
    return arr;
}


/**
 *  ajax请求, 对有些请求 要求安全性的时候， 进行加密
 * @param url   请求URL
 * @param data  参数 a=1&b=2 的形式
 * @param callback  回调函数
 * @param dataType  响应类型
 * @param needrsa   是否进行加密
 * @param dontNeedEc 不需要加密的数据
 */
function ajax(url, data, callback, dataType, needrsa, dontNeedEc) {

    var dataType = typeof(dataType) == 'undefined' ? 'json' : dataType;

    if (ping == 1) {
        return false;
    }
    ping = 1;

    var sendData = data;
    if (typeof (needrsa) != 'undefined' && needrsa) {
        $.getScript("/static/rsa/jsbn.js", function () {
            $.getScript("/static/rsa/prng4.js", function () {
                $.getScript("/static/rsa/rng.js", function () {
                    $.getScript("/static/rsa/rsa.js", function () {
                        $.getScript("/static/rsa/base64.js", function () {
                            if (!public_key || !public_length) {
                                console.log('缺少重要参数 ');
                            } else {
                                var rsa = new RSAKey();
                                rsa.setPublic(public_key, public_length);

                                var res = rsa.encrypt(data);
                                if (res) {
                                    rsaResult = hex2b64(res);
                                    sendData = {data: rsaResult};
                                    if (dontNeedEc) {
                                        sendData = $.extend(sendData, dontNeedEc);
                                    }
                                    runAjax(url, sendData, callback, dataType);
                                }
                            }
                        });
                    });
                });
            });
        });

    } else {
        runAjax(url, sendData, callback, dataType);
    }
}

function runAjax(url, sendData, callback, dataType) {
    sendData[csrf_name] = csrf_token;
    var index = layer.load(2, {shade: false});
    $.ajax({
        type: "POST",
        url: url,
        data: sendData,
        cache: false,
        dataType: dataType,
        beforeSend: function () {

        },
        success: function (res) {
            layer.close(index);
            ping = 0;

            if (typeof(callback) == 'function') {
                callback(res);
            }
        },
        error: function () {
            layer.close(index);

            layer.msg('请求出错， 请检查');
        }
    });
}


/**
 * LAYUI 打开IFRAME
 * @param url 地址
 * @param params 其它参数， 格式：a=1&b=2
 * @param w 宽
 * @param h 高
 */
function iframe(url, params, w, h) {
    var w = typeof(w) == 'undefined' ? 1100 : w;
    var h = typeof(h) == 'undefined' ? 660 : h;
    var params = typeof(params) == 'undefined' ? '' : params;

    if (typeof(url) == 'undefined') {
        console.log('URL不能为空');
        return;
    }
    var url = url.indexOf('?') > 0 ? url + '&inframe=1' + '&' + params : url + '?inframe=1&' + params;

    window.layer.index = layer.open({
        type: 2,
        title: false,
        area: [w + 'px', h + 'px'],
        shade: 0.7,
        closeBtn: 1,
        shadeClose: true,
        content: url
    });
}

/**
 * LAYUI 打开IFRAME，自定义HTMl
 */
function iframe_customize_html(id) {
    var content = typeof(id) == 'undefined'
        ? $('#iframe_customize_html').html()
        : $('#iframe_customize_html_' + id).html();

    layer.open({
        type: 1,
        title: '内容',
        area: ['80%', '560px'],
        closeBtn: 0,
        shadeClose: true,
        skin: 'iframe_customize_html',
        content: content
    });
}
