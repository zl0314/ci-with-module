<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= lang( 'login_title' ) ?></title>
    <link href="<?= ADMIN_CSS_PATH ?>style.css" rel="stylesheet" type="text/css"/>

    <!--    <link href="--><? //=JS_PATH?><!--layer/layer.css" rel="stylesheet" type="text/css">-->

    <script language="JavaScript" src="<?= ADMIN_JS_PATH ?>jquery.js"></script>
    <script language="JavaScript" src="/static/js/global.js"></script>
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
<div class="logintop">
    <span><?= lang( 'login_welcome' ) ?></span>
    <ul>
        <li><a href="/" target="_blank"><?=lang('back_to_index')?></a></li>
    </ul>
</div>

<div class="loginbody">

    <span class="systemlogo"></span>


    <?= form_open( '', [ 'onsubmit' => 'return checkForm()' ] ) ?>
    <div class="loginbox" style="top:25%;">

        <ul>
            <li><input type="text" autofocus class="loginuser" id="username" value=""/></li>
            <li><input type="password" class="loginpwd" id="password" value=""/></li>
            <li>
                <input type='text' class="dfinput" maxlength="4" placeholder="<?= lang( 'login_captcha' ) ?>"
                       name='captcha' id="captcha"
                       class="dl_wbk"
                       style="width:67.5%;float:left"/>
                <img src="<?= site_url( 'Captcha' ) ?>" id="captcha"
                     style="float:left;margin-left:2%;cursor: pointer;"
                     onclick="this.src='<?= site_url( 'Captcha' ) ?>'"/>

            </li>
            <input type="hidden" name="data" id="data">
            <div style="clear:both; height:8px;"></div>
            <li><input name="" type="submit" class="loginbtn" value="<?=lang('login')?>"/>
            </li>
        </ul>
    </div>
    <?= form_close() ?>
</div>


<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/jsbn.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/prng4.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/rng.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/rsa.js"></script>
<script language="JavaScript" type="text/javascript" src="<?= ADMIN_JS_PATH ?>rsa/base64.js"></script>

<script type="text/javascript" src="<?= ADMIN_JS_PATH ?>layer/layer.js"></script>

<script>
    var public_key = "<?=$config['rsa_module']?>";
    var public_length = "<?=$config['rsa_e']?>";

    function checkForm() {
        var username = password = captcha = '';
        username = $('#username').val();
        password = $('#password').val();
        captcha = $('#captcha').val();
        if (username == '') {
            layer_tip_mini('<?=lang('user_name_not_empty')?>');
            return false;
        }
        if (password == '') {
            layer_tip_mini('<?=lang('pwd_not_empty')?>');
            return false;
        }
        if (captcha == '') {
            layer_tip_mini('<?=lang('captcha_not_empty')?>');
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

<div class="loginbm"><?=lang('copyright')?></div>
</body>
</html>
