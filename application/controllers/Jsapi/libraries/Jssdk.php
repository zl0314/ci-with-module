<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/11/7 16:14
 * FileName : Jssdk.php
 */
class Jssdk extends WechatLib
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function getSignPackage ( $url = '' )
    {
        $jsapiTicket = $this->getJsApiTicket();
        $url = $url = $url ? $url : "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1( $string );

        $signPackage = [
            "appId"     => $this->appid,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string,
        ];

        return $signPackage;
    }

    private function createNonceStr ( $length = 16 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ( $i = 0; $i < $length; $i++ ) {
            $str .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
        }

        return $str;
    }

    /**
     * 获取ticket
     * @return ticket
     */
    private function getJsApiTicket ()
    {
        $where = [
            'appid' => $this->appid,
            'type'  => 3,
        ];
        $ticket_row = $this->CI->rs_model->getRow( $this->tokenTb, '*', $where );
        $timepass = intval( time() - strtotime( $ticket_row['created_at'] ) );

        if ( $timepass > 7000 ) {
            $accessToken = $this->getToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = $this->curlHttPost( $url );
            $ticket = $res->ticket;
            $data = [
                'appid'      => $this->appid,
                'token'      => $ticket,
                'created_at' => date( 'Y-m-d H:i:s' ),
                'type'       => 3,
            ];
            if ( $ticket ) {
                $this->CI->rs_model->save( $this->tokenTb, $data );
            }

            return $ticket;
        } else {
            return $ticket_row['token'];
        }
    }


}

