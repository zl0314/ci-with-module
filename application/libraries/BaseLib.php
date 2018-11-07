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
     * 全局配置项
     * @var array
     */
    public $config = [];

    public function __construct ()
    {
        $this->CI = &get_instance();
        $this->config = $this->CI->config->config;
    }
}