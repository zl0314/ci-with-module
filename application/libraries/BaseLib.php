<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/8/24 15:20
 * FileName : BaseLib.php
 */
class BaseLib
{
    /**
     * 全局CI对象
     * @var CI_Controller
     */
    public $CI;

    /**
     * 登录的管理员信息
     * @var
     */
    public $admin_info;

    /**
     * 全局配置项
     * @var array
     */
    public $config = [];

    public function __construct ()
    {
        $this->CI = &get_instance();
        $this->admin_info = $this->CI->session->userdata( 'admin_info' );

        $this->config = $this->CI->config->config;
    }
}