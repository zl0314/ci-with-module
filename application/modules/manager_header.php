<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>管理后台</title>


    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>jquery.js"></script>
    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>layer/layer.js"></script>
    <script type="text/javascript" src="<?= ADMIN_JS_PATH ?>select-ui.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Latest compiled and minified JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/static/admin/font/css/font-awesome.min.css">
    <link href="<?= ADMIN_CSS_PATH ?>style.css" rel="stylesheet" type="text/css"/>
    <script src="/static/admin/js/ajaxupload.3.9.js"></script>
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

    </ul>

    <div class="topright">
        <ul>
            <li><a href="/" target="_blank">站点首页</a></li>
            <li><a href="/<?= MANAGER_PATH ?>/Admin/logout" target="_parent">【退出系统】</a></li>
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
    <!--    <div class="lefttop"><span></span>通讯录</div>-->
    <dl class="leftmenu">
        <?php foreach ( $this->data['myMenus'] as $r ): ?>
            <dd>
                <div class="title">
                    <span></span><?= $r['name'] ?>
                </div>
                <?php if (!empty($r['submenu'])): ?>
                    <ul class="menuson">
                        <?php foreach ( $r['submenu'] as $rr ): ?>
                            <li id="menu_<?= $rr['controller'] ?>" <?php if ( $siteclass == $rr['controller'] ): ?> class="active" <?php endif; ?>>
                                <cite></cite>
                                <a href="<?= manager_url( $rr['controller'], $rr['param'] ) ?>"><?= $rr['name'] ?></a>
                                <i></i>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </dd>
        <?php endforeach; ?>

    </dl>
</div>
<script>
    $('.menuson').hide();
    $('#menu_<?=$siteclass?>').parent().show();
</script>
<!--main-->
<div id="right">
    <?php if ( !empty( $this->data['header'] ) ): ?>
        <?php $this->load->view( 'location' ); ?>
    <?php endif; ?>


    <?php if ( $sitemethod == 'index' ): ?>
    <div class="rightinfo">

        <div class="tools">
            <ul class="toolbar">
                <?php foreach ( $this->menu->getMenuByShowAt( [ 'show_at' => 2, 'parent_id' => $curMenu['id'] ] ) as $r ): ?>
                    <?php if ( $r['method'] == 'listorder' ): ?>

                        <li onclick="listOrder()"><span><img  src="<?= ADMIN_IMG_PATH ?><?= $r['method'] ?>.png"/></span><?= $r['name'] ?></li>

                    <?php elseif ( $r['method'] != 'batch_delete' ): ?>
                        <a href="<?= ADMIN_MANAGER_PATH ?>/<?= $r['method'] ?>">
                            <li class="click"><span><img
                                            src="<?= ADMIN_IMG_PATH ?><?= $r['method'] ?>.png"/></span><?= $r['name'] ?>
                            </li>
                        </a>
                    <?php else: ?>
                        <a href="javascript:;" onclick="delitem('a')">
                            <li><span><img src="<?= ADMIN_IMG_PATH ?><?= $r['method'] ?>.png"/></span><?= $r['name'] ?>
                            </li>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php else: ?>
            <div class="formbody">
                <div class="formtitle"><span>基本信息</span></div>
            </div>
        <?php endif; ?>
        <!--错误提示 模态框-->
        <?php if ( !empty( $this->session->flashdata( 'errors' ) ) ): ?>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">错误提示！</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="fa fa-info-circle fa-4x"></i>
                            </div>

                            <div class="col-sm-9">
                                <?php echo $this->session->flashdata( 'errors' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#exampleModal').modal()
        </script>

<?php endif; ?>