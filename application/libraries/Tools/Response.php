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

    /**
     * @var 缓存KEY 前缀
     */
    public $cacheKey;

    public function __construct ()
    {
        parent::__construct();
        $this->CI->load->library( 'Wechat/wxBizMsgCrypt', null, 'wxcrypt' );
        $this->CI->load->driver( 'cache', [ 'adapter' => 'redis', 'backup' => 'file' ] );
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
            'news'      => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>%s</ArticleCount><Articles>%s</Articles></xml>',
            'news_item' => '<item><Title><![CDATA[%s]]></Title> <Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>',
            'image'     => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[%s]]></MediaId></Image></xml>',
            'voice'     => '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[voice]]></MsgType><Voice><MediaId><![CDATA[%s]]></MediaId></Voice></xml>',
        ];

        return $arr[ $fetch ];
    }

    /**
     * 返回消息
     *
     * @param $postObj 微信发送的消息体
     */
    public function prepareSendMsg ( $postStr )
    {
        Mylog::error( 'poststr ' . $postStr );

        $postObj = $this->getDecryptedMsg( $postStr );
        Mylog::error( 'decrypted postObj ' . var_export( $postObj, true ) );

        if ( !empty( $postObj ) ) {
            $this->postObj = $postObj;
            $this->cacheKey = md5( $postObj->FromUserName );
            $this->responseMsg();
        } else {
            echo 'success';
        }
    }

    //返回消息
    public function responseMsg ()
    {
        //返回图片
        if ( $this->postObj->Content == '图片' ) {
            $respondMsg = sprintf( $this->getResponseMsgTmp( 'image' ),
                $this->postObj->FromUserName,
                $this->postObj->ToUserName,
                time(),
                'Tl4K-cmWmCB_DQe49FhPmdqvhx5t5I-UBDOC2uR9Isk'
            );
            $this->echoMsgToWechat( $respondMsg );
        } else if ( $this->postObj->Content == '上传素材' || $this->CI->cache->redis->get( $this->cacheKey . '_action' ) == 'uploadMaterial' ) {

            $action = 'uploadMaterial';
            $this->CI->load->library( 'Tools/UploadMaterial', null, 'targetObj' );
        }

        if ( isset( $this->CI->targetObj ) ) {
            if ( !$this->CI->cache->redis->get( $this->cacheKey . '_action' ) ) {
                $this->CI->cache->redis->save( $this->cacheKey . '_action', $action, 7200 );
            }
            $this->CI->targetObj->postObj = $this->postObj;
            $this->CI->targetObj->cacheKey = md5( $this->postObj->FromUserName );

            $this->CI->targetObj->startProcess();
        }

        /**
         * 发送的关键字， 是否能在新闻表中找到， 如果未找到， 返回默认消息， 找到返回图文消息
         */
        $this->FoundKeywordResource();
    }

    /**
     * 查找关键字，查找到， 并返回消息， 没查找到，返回默认消息
     * @return bool
     */
    public function FoundKeywordResource ()
    {
        $keyword = $this->CI->rs_model->getRow( 'keyword', 'target_id,source', [
            'keyword' => $this->postObj->Content,
        ] );

        if ( !empty( $keyword['target_id'] ) ) {
            $news = $this->CI->rs_model->getRow( strtolower( $keyword['source'] ), 'id,title,description,thumb', [ 'id' => $keyword['target_id'] ] );
            if ( !empty( $news['id'] ) ) {
                if ( strtolower( $keyword['source'] ) == 'news' ) {
                    $this->responseNewsMsg( $news, 1 );
                } else if ( strtolower( $keyword['source'] ) == 'material' ) {
                    $this->responseImageMsg( $news['mediaId'] );
                }
            } else {
                $this->responseTextMsg( '非常抱歉！ 没有发现您要找的内容^^，换一个关键词试一下吧~' );
            }
        } else {
            $this->responseTextMsg( '非常抱歉！ 没有发现您要找的内容^^，换一个关键词试一下吧~' );
        }
    }

    /**
     * 消息解密处理
     *
     * @param $postObj 微信发送的消息体
     */
    protected function getDecryptedMsg ( $postStr )
    {
        if ( WECHAT_RESPONSE_TYPE == 1 ) {
            $this->CI->wxcrypt->init( TK, EK, APPID );
            $decryptMsg = '';
            $errCode = $this->CI->wxcrypt->decryptMsg( _get( 'msg_signature' ), _get( 'timestamp' ), _get( 'nonce' ), $postStr, $decryptMsg );
            Mylog::error( 'decrypted errorno ' . $errCode );
            if ( $errCode == 0 ) {
                if ( !empty( $decryptMsg ) ) {
                    Mylog::error( 'decrypted msg ' . $decryptMsg );

                    $postObj = simplexml_load_string( $decryptMsg, 'SimpleXMLElement', LIBXML_NOCDATA );

                    return $postObj;
                } else {
                    echo 'success1';
                }
            } else {
                echo 'success2';
                Mylog::error( "解密失败：" . $errCode );
            }
        } else {
            $postObj = simplexml_load_string( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );

            return $postObj;
        }
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
        Mylog::error( 'response text source ' . $respondMsg . ob_get_contents() );
        echo $msg;
        Mylog::error( 'response text ' . $msg . var_export( $this->postObj, true ) . ob_get_contents() );
        exit;
    }


    /**
     * 返回文本消息
     *
     * @param $msg 返回的消息
     */
    public function responseTextMsg ( $msg )
    {
        $temp = $this->getResponseMsgTmp( 'text' );

        $respondMsg = sprintf( $temp,
            $this->postObj->FromUserName,
            $this->postObj->ToUserName,
            time(),
            $msg
        );

        $this->echoMsgToWechat( $respondMsg );
    }

    /**
     * 返回新闻消息
     *
     * @param     $news  新闻 记录
     * @param int $count 条数
     */
    public function responseNewsMsg ( $news, $count = 1 )
    {

        $temp = $this->getResponseMsgTmp( 'news' );
        $tempItem = $this->getResponseMsgTmp( 'news_item' );
        //新闻项模板
        if ( $count == 1 ) {
            $newsItem = sprintf( $tempItem,
                $news['title'],
                $news['description'],
                SITE_URL . $news['thumb'],
                site_url( 'News/show/' . $news['id'] )
            );
        } else {
            $newsItem = '';
            $count = count( $news );
            foreach ( $news as $k => $r ) {
                $newsItem .= sprintf( $tempItem,
                    $r['title'],
                    $r['description'],
                    SITE_URL . $r['thumb'],
                    site_url( 'News/show/' . $r['id'] )
                );
            }
        }

        //返回消息模板
        $responseMsg = sprintf( $temp,
            $this->postObj->FromUserName,
            $this->postObj->ToUserName,
            time(),
            $count,
            $newsItem
        );
        $this->echoMsgToWechat( $responseMsg );
    }

    /**
     * 返回图片消息
     *
     * @param $mediaId  媒体 ID
     */
    public function responseImageMsg ( $mediaId )
    {
        $respondMsg = sprintf( $this->getResponseMsgTmp( 'image' ),
            $this->postObj->FromUserName,
            $this->postObj->ToUserName,
            time(),
            $mediaId
        );
        $this->echoMsgToWechat( $respondMsg );
    }
}