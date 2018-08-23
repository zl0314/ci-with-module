<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>管理后台</title>


    <link href="<?= ADMIN_CSS_PATH ?>style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>jquery.js"></script>
    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>layer/layer.js"></script>
    <link href="<?= ADMIN_CSS_PATH ?>select.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>select-ui.min.js"></script>
    <script src="/static/layer/layer.js"></script>
    <script src="/static/js/global.js"></script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({
                headers: { // 默认添加请求头
                    '<?= $this->security->get_csrf_token_name(); ?>': '<?= $this->security->get_csrf_hash(); ?>'
                },
            });
            //顶部导航切换
            $(".nav li a").click(function () {
                $(".nav li a.selected").removeClass("selected")
                $(this).addClass("selected");
            })
        })
        $(function () {
            //导航切换
            $(".menuson li").click(function () {
                $(".menuson li.active").removeClass("active")
                $(this).addClass("active");
            });

            $('.title').click(function () {
                var $ul = $(this).next('ul');
                $('dd').find('ul').slideUp();
                if ($ul.is(':visible')) {
                    $(this).next('ul').slideUp();
                } else {
                    $(this).next('ul').slideDown();
                }
            });
        })

        var public_key = "<?=$config['rsa_module']?>";
        var public_length = "<?=$config['rsa_e']?>";
        var SITEC = '<?php echo SITEC;?>';
        var SITEM = '<?php echo SITEM;?>';
        var DOMAIN = 'http://' + document.domain + '/';
        var doit = false;
        var is_manager = true;
        var ping = 0;
    </script>

</head>

<body style="background:url(<?= ADMIN_IMG_PATH ?>topbg.gif) repeat-x;">

<div id="top">

    <div class="topleft">
        <a href="<?= ADMIN_MANAGER_PATH ?>" target="_parent"><img src="<?= ADMIN_IMG_PATH ?>logo.png" title="系统首页"/></a>
    </div>

    <ul class="nav">

        <li><a href="<?= manager_url( 'Admin' ) ?>" class="selected">
                <h2>首页</h2></a></li>

        <li><a href="<?= manager_url( 'Privileges' ) ?>">
                <h2>权限节点</h2></a></li>

        <li><a href="<?= manager_url( 'Adminuser' ) ?>">
                <h2>管理员管理</h2></a></li>
        <li><a href="<?= manager_url( 'Setting' ) ?>">
                <h2>系统设置</h2></a></li>

    </ul>

    <div class="topright">
        <ul>
            <!--<li><span><img src="<?= ADMIN_IMG_PATH ?>help.png" title="帮助" class="helpimg"/></span><a href="#">帮助</a></li>
    <li><a href="#">关于</a></li>-->
            <li><a href="<?= ADMIN_MANAGER_PATH ?>/logout" target="_parent">【退出系统】</a></li>
        </ul>

        <div class="user">
            <span><?= $admin_info['nickname'] ?></span>
            <!--<i>消息</i>
            <b>5</b>-->
        </div>

    </div>
</div>


<!--left-->
<div id="left">
    <div class="lefttop"><span></span>通讯录</div>
    <dl class="leftmenu">
        <dd>
            <div class="title">
                <span></span>管理信息
            </div>
            <ul class="menuson">
                <li><cite></cite><a href="index.html">首页模版</a><i></i></li>
                <li class="active"><cite></cite><a href="right.html">数据列表</a><i></i></li>
                <li><cite></cite><a href="imgtable.html">图片数据表</a><i></i></li>
                <li><cite></cite><a href="form.html">添加编辑</a><i></i></li>
                <li><cite></cite><a href="imglist.html">图片列表</a><i></i></li>
                <li><cite></cite><a href="imglist1.html">自定义</a><i></i></li>
                <li><cite></cite><a href="tools.html">常用工具</a><i></i></li>
                <li><cite></cite><a href="filelist.html">信息管理</a><i></i></li>
                <li><cite></cite><a href="tab.html">Tab页</a><i></i></li>
                <li><cite></cite><a href="error.html">404页面</a><i></i></li>
            </ul>
        </dd>


        <dd>
            <div class="title">
                <span></span>其他设置
            </div>
            <ul class="menuson">
                <li><cite></cite><a href="#">编辑内容</a><i></i></li>
                <li><cite></cite><a href="#">发布信息</a><i></i></li>
                <li><cite></cite><a href="#">档案列表显示</a><i></i></li>
            </ul>
        </dd>


        <dd>
            <div class="title"><span></span>编辑器</div>
            <ul class="menuson">
                <li><cite></cite><a href="#">自定义</a><i></i></li>
                <li><cite></cite><a href="#">常用资料</a><i></i></li>
                <li><cite></cite><a href="#">信息列表</a><i></i></li>
                <li><cite></cite><a href="#">其他</a><i></i></li>
            </ul>
        </dd>


        <dd>
            <div class="title"><span></span>日期管理</div>
            <ul class="menuson">
                <li><cite></cite><a href="#">自定义</a><i></i></li>
                <li><cite></cite><a href="#">常用资料</a><i></i></li>
                <li><cite></cite><a href="#">信息列表</a><i></i></li>
                <li><cite></cite><a href="#">其他</a><i></i></li>
            </ul>

        </dd>

    </dl>
</div>
<!--main-->
<div id="right">
    <?php if ( !empty( $this->data['header'] ) ): ?>
        <?php $this->load->view( 'location' ); ?>
    <?php endif; ?>
