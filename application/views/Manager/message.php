<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?= $err ?></title>
    <link href="<?= ADMIN_CSS_PATH ?>style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>jquery.js"></script>

    <script language="javascript">
        $(function () {
            $('.error').css({'position': 'absolute', 'left': ($(window).width() - 490) / 2});
            $(window).resize(function () {
                $('.error').css({'position': 'absolute', 'left': ($(window).width() - 490) / 2});
            })
        });
    </script>


</head>


<body style="background:#edf6fa;">
<div class="error" style="background:url(/static/admin/images/<?=$type?>.png) top left no-repeat;">

    <h2><?= $err ?></h2>
    <p>
<!--        看到这个提示，就自认倒霉吧!-->
        <?php if(!empty($url)):?>
        <i id="sec_jump" style="font-weight: bold;"><?php echo $sec / 1000 ?></i> 秒后浏览器自动跳转...</i> </p>
    <?php endif;?>

    <?php if (empty($url)): ?>
        <div class="reindex"><a href="/">返回首页</a></div>
    <?php else: ?>
        <div class="reindex"><a href="<?php echo $url; ?>">点击进行跳转</a></div>
    <?php endif; ?>

</div>
<script>
    var sec = '<?php echo $sec?>';
    var url = '<?php echo $url?>';
    <?php if($url):?>
    setTimeout('jump()', sec);
    <?php else:?>
    <?php endif;?>
    function jump() {
        if (url) {
           window.location.href = url;
        }
    }
</script>

</body>
</html>
<?php exit; ?>