<?php
/**
 * 响应微信消息给用户
 * Created by Aaron Zhang.
 * Date: 2018/11/15 13:51
 * FileName : ResponoNormal.php
 */

class Response extends WechatLib
{
    /**
     * @var 微信解密类
     */
    public $wxcrypt;

    /**
     * @var 解密后的微信消息实体
     */
    public $postObj;

    /**
     * @var 微信 用户信息
     */
    public $userinfo;

    public function __construct ()
    {
        parent::__construct();
        $this->CI->load->library( 'Wechat/wxBizMsgCrypt', null, 'wxcrypt' );
    }

    /**
     * 向微信客户端输出消息
     *
     * @param $respondMsg 返回的消息实体
     */
    public function echoMsgToWechat ( $respondMsg )
    {
        $time = time();
        $encryptMsg = '';
        if ( WECHAT_RESPONSE_TYPE == 1 ) {
            $this->CI->wxcrypt->encryptMsg( $respondMsg, $time, $time, $encryptMsg );
            $msg = $encryptMsg;
        } else {
            $msg = $respondMsg;
        }
        echo $msg;
        Mylog::error( 'response text ' . $msg . var_export( $this->postObj, true ) );
        exit;
    }

    /**
     * 获取响应模板
     *
     * @param string $fetch [text | news | news_item]
     *
     * @return mixed
     */
    public function getResponseMsgTmp ( $fetch = 'text' )
    {
        $arr = [
            'text'      => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>',
            'NewsLib'   => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>%s</ArticleCount><Articles>%s</Articles></xml>',
            'news_item' => '<item><Title><![CDATA[%s]]></Title> <Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>',
        ];

        return $arr[ $fetch ];
    }

    /**
     * 获取用户信息
     *
     * @param $openid
     *
     * @return mixed
     */
    public function getUserInfo ( $openid )
    {
        $this->CI->load->library( 'Tools/GetWechatUserinfo', null, 'userobj' );
        $this->CI->userobj->setAppid( APPID );
        $this->CI->userobj->setAppSec( APPSEC );

        $result = $this->CI->userobj->getCgiUserInfo( $openid );

        return $result;
    }

    /**
     * 返回消息
     *
     * @param $postObj 微信发送的消息体
     */
    public function prepareSendMsg ( $postStr )
    {
        Mylog::error( 'poststr ' . $postStr );

        $postObj = $this->parseMsg( $postStr );
        if ( !empty( $postObj ) ) {
            $msgType = ucfirst( $postObj->MsgType );
            $name = $msgType . 'Response';

            //调用具体 类型的类
            $this->CI->load->library( 'Tools/' . $name, null, 'msgobj' );
            $this->CI->msgobj->postObj = $postObj;
            $this->CI->msgobj->responseMsg();
        } else {
            echo 'success';
        }
    }

    /**
     * 消息解密处理
     *
     * @param $postObj 微信发送的消息体
     */
    protected function parseMsg ( $postStr )
    {
        if ( WECHAT_RESPONSE_TYPE == 1 ) {
            $this->CI->wxcrypt->init( TK, EK, APPID );
            $decryptMsg = '';
            $errCode = $this->CI->wxcrypt->decryptMsg( _get( 'msg_signature' ), _get( 'timestamp' ), _get( 'nonce' ), $postStr, $decryptMsg );
            if ( $errCode == 0 ) {
                if ( !empty( $decryptMsg ) ) {
                    $postObj = simplexml_load_string( $decryptMsg, 'SimpleXMLElement', LIBXML_NOCDATA );

                    return $postObj;
                } else {
                    echo 'success';
                }
            } else {
                echo 'success';
                Mylog::error( "解密失败：" . $errCode );
            }
        } else {
            $postObj = simplexml_load_string( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );

            return $postObj;
        }
    }

}