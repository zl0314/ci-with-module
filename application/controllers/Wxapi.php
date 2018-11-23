<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );


class Wxapi extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->library( 'WechatLib' );
    }

    public function index ()
    {
        $postStr = file_get_contents( 'php://input' );

        if ( !empty( $postStr ) ) {
            $this->load->library( 'Tools/Response' );

            $this->response->prepareSendMsg( $postStr );
        } else {
            if ( !empty( _get( 'signature' ) ) ) {
                $this->checkSignature();
            }
        }
    }

    private function checkSignature ()
    {
        $signature = !empty( $_GET['signature'] ) ? $_GET['signature'] : '';
        $timestamp = !empty( $_GET['timestamp'] ) ? $_GET['timestamp'] : '';
        $nonce = !empty( $_GET['nonce'] ) ? $_GET['nonce'] : '';
        $echostr = !empty( $_GET['echostr'] ) ? $_GET['echostr'] : '';
        $token = TK;

        //Mylog::error('$_GET = '.var_export($_GET, true));

        //组合
        $signatureArray = [ $token, $timestamp, $nonce ];
        //字典排序
        sort( $signatureArray );
        //sha1加密、验证
        if ( sha1( implode( $signatureArray ) ) == $signature ) {
            echo $echostr;
            exit;
        }
    }
}