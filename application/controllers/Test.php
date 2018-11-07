<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/10/23 19:47
 * FileName : Test.php
 */
class Test extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function index ()
    {
        $this->load->library( 'Rsa' );
        $result = $this->rsa->publicDecrypt( '12312' );
        echo '加密后：' . $result;
        echo '<br>';
        echo '解密后：' . $this->rsa->privateDecrypt( $result );
    }
}