<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/11/7 16:12
 * FileName : Jsapi.php
 */

class Jsapi extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function index ()
    {
        $this->load->library( 'Jssdk' );
        $this->jssdk->setAppid( APPID );
        $this->jssdk->setAppSec( APPSEC );
        $signPackage = $this->jssdk->GetSignPackage( @$_SERVER['HTTP_REFERER'] );

        echo json_encode( $signPackage );
    }
}