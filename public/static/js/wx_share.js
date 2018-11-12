var domain = 'http://' + document.domain;
var title = typeof (sharetitle) == 'undefined' ? '分享标题' : sharetitle;
var desc = typeof (sharedesc) == 'undefined' ? '分享描述' : sharedesc;
var img = typeof (shareimg) == 'undefined' ? '' : shareimg;
var link = typeof (sharelink) == 'undefined' ? window.location.href : sharelink;
var shareData = {
    title: title,
    desc: desc,
    imgUrl: img,
    link: link
}
var debug = typeof (debug) == 'undefined' ? false : debug;

$.getScript('http://res.wx.qq.com/open/js/jweixin-1.4.0.js', function (res) {
    $.get(domain + '/Jsapi', '', function (res) {
        wx.config({
            debug: debug, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: res.appId, // 必填，公众号的唯一标识
            timestamp: res.timestamp, // 必填，生成签名的时间戳
            nonceStr: res.nonceStr, // 必填，生成签名的随机串
            signature: res.signature,// 必填，签名
            jsApiList: [
                // 'updateAppMessageShareData',
                // 'updateTimelineShareData',
                'onMenuShareAppMessage',
                'onMenuShareTimeline'
            ] // 必填，需要使用的JS接口列表
        });
        wx.ready(function () {

            wx.onMenuShareTimeline({
                title: shareData.title, // 分享标题
                link: shareData.url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: shareData.imgUrl, // 分享图标
                success: function (res) {
                    // 用户点击了分享后执行的回调函数
                    if (typeof(shareCallback) == 'function') {
                        shareCallback(res);
                    }
                },
            })
            wx.onMenuShareAppMessage({
                title: shareData.title, // 分享标题
                link: shareData.url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
                imgUrl: shareData.imgUrl, // 分享图标
                desc: shareData.desc, // 分享图标
                success: function (res) {
                    if (typeof(shareCallback) == 'function') {
                        shareCallback(res);
                    }
                }
            });
        })
    }, 'json');

})