<?php

/**
 * Created by Aaron Zhang.
 * @email : nice5good@126.com
 * Date: 2017/12/19 22:36
 * FileName : MY_Controller.php
 */
class Common_Controller extends CI_Controller
{
    /**
     * 是否是微信端
     * @var int
     */
    public $is_wechat = 0;

    /**
     * 是否是手机端
     * @var int
     */
    public $is_mobile = 0;

    /**
     * 控制器
     * @var
     */
    public $siteclass;

    /**
     * 方法
     * @var
     */
    public $sitemethod;

    public function __construct ()
    {
        parent::__construct();


        $this->siteclass = $this->router->class;
        $this->sitemethod = $this->router->method;

        $this->data['siteclass'] = $this->router->class;
        $this->data['sitemethod'] = $this->router->method;

        //判断是否是微信
        if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false ) {
            $this->is_wechat = true;
        }
        //判断是否是手机端
        $this->is_mobile = $this->ua->is_mobile;
    }

}

class Base_Controller extends Common_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }
}

class MY_Controller extends Common_Controller
{

    public function __construct ()
    {
        parent::__construct();
    }

}

/* 加载模块 主控制器*/
if ( file_exists( MODULE_PATH . MODULE_CONTROLLER . '.php' ) ) {
    require_once MODULE_PATH . MODULE_CONTROLLER . '.php';
}