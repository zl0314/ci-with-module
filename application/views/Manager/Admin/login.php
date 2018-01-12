<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>欢迎登录后台管理系统</title>
    <link href="<?= ADMIN_CSS_PATH ?>style.css" rel="stylesheet" type="text/css"/>

    <!--    <link href="--><? //=JS_PATH?><!--layer/layer.css" rel="stylesheet" type="text/css">-->

    <script language="JavaScript" src="<?= ADMIN_JS_PATH ?>jquery.js"></script>
    <script language="JavaScript" src="<?= ADMIN_JS_PATH ?>global.js"></script>
    <!--    <script src="--><? //= JS_PATH ?><!--cloud.js" type="text/javascript"></script>-->

    <script language="javascript">
        $(function () {
            $('.loginbox').css({'position': 'absolute', 'left': ($(window).width() - 692) / 2});
            $(window).resize(function () {
                $('.loginbox').css({'position': 'absolute', 'left': ($(window).width() - 692) / 2});
            })
        });
    </script>

</head>

<body style="background-color:#1c77ac; background-image:url(<?= ADMIN_IMG_PATH ?>light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">
<!---->
<!---->
<!--<div id="mainBody">-->
<!--    <div id="cloud1" class="cloud"></div>-->
<!--    <div id="cloud2" class="cloud"></div>-->
<!--</div>-->


<div class="logintop">
    <span>欢迎登录后台管理界面平台</span>
    <ul>
        <li><a href="/" target="_blank">回首页</a></li>
    </ul>
</div>

<div class="loginbody">

    <span class="systemlogo"></span>

    <form action="" method="post" onsubmit="return checkForm()">
        <div class="loginbox">

            <ul>
                <li><input name="" type="text" autofocus class="loginuser" id="username" value=""/></li>
                <li><input name="" type="text" class="loginpwd" id="password" value=""/></li>
                <li>
                    <input type='text' class="dfinput" maxlength="4" placeholder="验证码" name='captcha' id="captcha"
                           class="dl_wbk"
                           style="width:67.5%;float:left"/>
                    <img src="<?= site_url('Api/Captcha') ?>" id="captcha"
                         style="float:left;margin-left:2%;cursor: pointer;"
                         onclick="this.src='<?= site_url('Api/Captcha') ?>'"/>

                </li>
                <input type="hidden" name="data" id="data">
                <div style="clear:both; height:8px;"></div>
                <li><input name="" type="submit" class="loginbtn" value="登录"/>
                    <!--
                   <label>
                        <input name="" type="checkbox" value="" checked="checked"/>记住密码
                   </label>
                   <label><a href="#">忘记密码？</a></label>
                   -->
                </li>
            </ul>
        </div>
    </form>
</div>


<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/jsbn.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/prng4.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/rng.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/rsa.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/base64.js"></script>

<script type="text/javascript" src="<?= ADMIN_JS_PATH ?>layer/layer.js"></script>

<script>
    var public_key = "<?=RSA_KEY?>";
    var public_length = "<?=RSA_LEN?>";

    function checkForm() {
        var username = password = captcha = '';
        username = $('#username').val();
        password = $('#password').val();
        captcha = $('#captcha').val();
        if (username == '') {
            layer_tip_mini('用户名不能为空');
            return false;
        }
        if (password == '') {
            layer_tip_mini('密码不能为空');
            return false;
        }
        if (captcha == '') {
            layer_tip_mini('验证码不能为空');
            return false;
        }

        var rsa = new RSAKey();
        rsa.setPublic(public_key, public_length);
        var res = rsa.encrypt('username=' + $('#username').val() + '&password=' + $('#password').val());
        if (res) {
            var result = hex2b64(res);
            $('#data').val(result);
            return true;
        }
    }
</script>

<div class="loginbm"><a href="<?= site_url() ?>"><?= site_url() ?></a></div>
</body>
</html>
