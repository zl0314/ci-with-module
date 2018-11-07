<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/8/24 15:20
 * FileName : BaseLib.php
 */
class WechatLib extends BaseLib
{
    /**
     * @var APPID
     */
    public $appid;
    /**
     * @var APPSEC
     */
    public $appsec;
    /**
     * CGIURL
     * @var string
     */
    public $cgiUrl = 'https://api.weixin.qq.com/cgi-bin/';

    /**
     * 存储TOKEN表
     * @var string
     */
    public $tokenTb = 'tokens';

    public function __construct ()
    {
        parent::__construct();

        return static::init();
    }

    /**
     * 设置APPID
     *
     * @param $appid
     */
    public function setAppid ( $appid )
    {
        $this->appid = $appid;
    }

    /**
     * 设置APPSEC
     *
     * @param $appsec
     */
    public function setAppSec ( $appsec )
    {
        $this->appsec = $appsec;
    }

    public function init ()
    {
    }

    /**
     * 获取access_token
     * @return mixed 获取后的Token
     */
    public function getToken ()
    {
        $fetchResult = $this->CI->rs_model->getRow( $this->tokenTb, '*', [ 'appid' => $this->appid, 'type' => 1 ] );
        if ( empty( $fetchResult['id'] ) ) {
            $token = $this->generateToken();
        } else if ( strtotime( $fetchResult['created_at'] ) + 7000 < time() ) {
            $token = $this->generateToken( $fetchResult );
        } else {
            $token = $fetchResult['token'];
        }

        return $token;
    }

    /**
     * 去微信获取Token
     * @return mixed
     */
    protected function generateToken ( $fetchResult = null )
    {
        $url = $this->cgiUrl . 'token?grant_type=client_credential&appid=' . $this->appid . '&secret=' . $this->appsec;
        $result = $this->curlHttPost( $url );
        if ( empty( $fetchResult['id'] ) ) {
            $data = [
                'token'      => $result->access_token,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'appid'      => $this->appid,
                'type'       => 1,
            ];
            $this->CI->rs_model->save( $this->tokenTb, $data );
        } else if ( !empty( $fetchResult['id'] ) ) {
            $data = [
                'token'      => $result->access_token,
                'created_at' => date( 'Y-m-d H:i:s' ),
            ];
            $this->CI->rs_model->update( $this->tokenTb, $data, [ 'appid' => $this->appid, 'type' => 1 ] );
        }

        return $result->access_token;
    }

    /**
     * 返回Json数据
     *
     * @param     $data  数据
     * @param int $code  CODE
     *
     * @return mixed
     */
    public function json ( $data, $code = 0 )
    {
        $returnData = is_object( $data ) ? (array) $data : ( is_array( $data ) ? $data : [] );
        $returnData['message'] = !empty( $data['errmsg'] ) ? $data['errmsg'] : '';

        if ( is_string( $data ) ) {
            $returnData['message'] = $data;
        }
        $returnData['code'] = $code ? $code : ( !empty( $data['errcode'] ) ? $data['errcode'] : 0 );

        if ( isAjax() ) {
            echo json_encode( $returnData );
        } else {
            exit( $data );
        }
        exit;
    }

    /**
     * 获取网页版Access_token
     *
     * @param        $redirect   跳回来的URL
     * @param string $state
     *
     * @return mixed
     */
    public function getWechatSnsToken ( $redirect, $state = 'getuserinfo' )
    {
        if ( !$redirect ) {
            $this->json( '缺少redirect uri 参数' );
        }
        if ( !_get( 'code' ) && !_get( 'state' ) ) {
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->appid . '&redirect_uri=' . $redirect . '&response_type=code&scope=snsapi_userinfo&state=' . $state;
            redirect( $url );
        } else {
            $code = _get( 'code' );
            $snsUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->appid . '&secret=' . $this->appsec . '&code=' . $code . '&grant_type=authorization_code';
            $result = $this->curlHttPost( $snsUrl );
            if ( !empty( $result->access_token ) ) {
                return $result;
            } else {
                $this->json( '网页获取Access token 失败' );
            }
        }
    }


    /**
     * 发送HTTP请求
     *
     * @param       $url
     * @param array $data
     *
     * @return mixed
     */
    public function curlHttPost ( $url, $data = [] )
    {
        $ch = curl_init( trim( $url ) );
        curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

        if ( !empty( $data ) ) {
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, ( $data ) );
        }

        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1 );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
        $result = curl_exec( $ch );

        curl_close( $ch );
        $output = json_decode( $result );
        if ( !empty( $output->errcode ) ) {
            if ( isAjax() ) {
                $this->json( $output->errmsg, $output->errcode );
            } else {
                exit( $output->errcode . ' ' . $output->errmsg );
            }
        }

        return $output;
    }
}
