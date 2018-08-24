
    <div class="mainindex" style="margin-top: -50px;">
        <div class="welinfo">
            <!--        <span><img src="--><? //=ADMIN_IMG_PATH?><!--sun.png" alt="天气"/></span>-->
            <b>Hello <?= $admin_info['nickname'] ?>，欢迎使用管理系统</b>
<!--            <a href="javascript:;">帐号设置</a>-->
        </div>

        <div class="welinfo">
            <span><img src="<?= ADMIN_IMG_PATH ?>time.png" alt="时间"/></span>
            <i>您上次登录的时间：<?= $admin_info['last_login_time'] ?></i>
        </div>

        <div class="xline"></div>
    </div>




