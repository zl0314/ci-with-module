<?php
/**
 * 响应微信消息给用户（文本模式）
 * Created by Aaron Zhang.
 * Date: 2018/11/15 15:02
 * FileName : TextResponse.php
 */

class TextResponse extends Response
{
    public function __construct ()
    {
        parent::__construct();
    }


    public function responseMsg ()
    {
        $temp = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>';
        $time = time();
        //获取用户信息
        $userinfo = $this->getUserInfo( $this->postObj->FromUserName );

        $respondMsg = sprintf( $temp,
            $this->postObj->FromUserName,
            $this->postObj->ToUserName,
            $time,
            '你好！ ' . $userinfo->nickname . ' 现在是 ' . date( 'Y-m-d H:i:s' )
        );
        $encryptMsg = '';

        if ( WECHAT_RESPONSE_TYPE == 1 ) {
            $this->CI->wxcrypt->encryptMsg( $respondMsg, $time, $time, $encryptMsg );
            $msg = $encryptMsg;
        } else {
            $msg = $respondMsg;
        }
        echo $msg;
        Mylog::error( 'response text ' . $msg . var_export( $this->postObj, true ) );

    }
}