<?php

/**
 * 获取微信用户信息
 * Created by Aaron Zhang.
 * Date: 2018/11/7 11:11
 * FileName : GetUserinfo.php
 */
class GetWechatUserinfo extends WechatLib
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function init ()
    {

    }

    /**
     * 网页版获取用户信息
     *
     * @param  $redirect 回调URL
     *
     * @return mixed
     */
    public function getWechatSnsUserInfo ( $redirect = '' )
    {
        $userInfo = $this->CI->session->userdata( 'sns_wechat_userinfo' );
        if ( !empty( $userInfo->openid ) ) {
            return $userInfo;
        } else {
            $redirect = _get( 'redirect' ) ? _get( 'redirect' ) : ( $redirect ? $redirect : SITE_URL );
            $tokenResult = $this->getWechatSnsToken( urlencode( $redirect ) );
            $tokenUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $tokenResult->access_token . '&openid=' . $tokenResult->openid . '&lang=zh_CN';
            $userResult = $this->curlHttPost( $tokenUrl );
            if ( !empty( $userResult->openid ) ) {
                $this->CI->session->set_userdata( 'sns_wechat_userinfo', $userResult );

                return $userResult;
            }
        }

    }


}