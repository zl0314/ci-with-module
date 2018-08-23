function layer_tip(msg, btn) {
    var btn = typeof(btn) == 'undefined' ? '确定' : btn;
    setTimeout(function () {
        layer.open({
            content: msg,
            btn: btn
        })
    }, 350);
}

function layer_tip_mini(msg, fun) {
    layer.alert(msg, {
        skin: 'layui-layer-lan'
        , closeBtn: 0
    });
    if (typeof(fun) == 'function') {
        setTimeout(function () {
            fun();
        }, 1000);
    }
}