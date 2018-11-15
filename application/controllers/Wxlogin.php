<?php
/**
 * 微信登录， 获取微信用户授权信息
 * Created by Aaron Zhang.
 * Date: 2018/11/15 10:55
 * FileName : Wxlogin.php
 */

class Wxlogin extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function index ()
    {
        $this->load->library( 'Tools/GetWechatUserinfo', [], 'userinfo' );
        $redirect = site_url( '/' );
        $this->userinfo->setAppid( APPID );
        $this->userinfo->setAppSec( APPSEC );

        $result = $this->userinfo->getWechatSnsUserInfo( $redirect );
        $vars = [
            'wxUserinfo' => !empty( $result ) ? $result : null,
        ];
        $this->tpl->assign( $vars );
        $this->tpl->display();
    }
}