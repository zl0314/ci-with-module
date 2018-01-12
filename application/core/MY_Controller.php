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

    /**
     * @var 配置项， 只加载config/config.php
     */
    public $_config;

    /**
     * @var 是否是后台管理操作
     */
    public $is_manager = false;

    public function __construct()
    {
        parent::__construct();

        //判断是否是后台管理
        $uri_first = $this->uri->segment(1);
        if ($uri_first == MANAGER_PATH) {
            $this->is_manager = true;
        }

        $config = $this->config->config;
        $this->_config = $config;

        $this->siteclass = $this->router->class;
        $this->sitemethod = $this->router->method;

        /**
         * 当前控制器
         */
        define('SITEC', ucfirst($this->siteclass));
        /**
         * 当前的方法
         */
        define('SITEM', ucfirst($this->sitemethod));


        /**
         * 判断是否是微信
         */
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $this->is_wechat = true;
        }

        /**
         * 判断是否是手机端
         */
        $this->is_mobile = $this->ua->is_mobile;
    }

}

/**
 * Class Base_Controller 后端主控制器
 */
class Base_Controller extends Common_Controller
{
    /**
     * 登录的管理员信息
     */
    public $admin_info;

    public function __construct()
    {
        parent::__construct();
        $this->checkAdminLogin();

        $this->admin_info = $this->session->userdata('admin_info');
        $this->data['admin_info'] = $this->admin_info;

        //定义后台路径
        define('ADMIN_MANAGER_PATH', site_url(MANAGER_PATH . '/' . SITEC)); //只到当前控制器
        define('ADMIN_MANAGER_FULL_PATH', site_url(MANAGER_PATH . '/' . SITEC . '/' . SITEM)); // 到控制器下面的方法

        //定义头尾文件
//        $this->data['header'] = $this->is_manager ? SITEC . '/' . strtolower(MANAGER_PATH) . '_header' : SITEC . '/header';
//        $this->data['footer'] = $this->is_manager ? SITEC . '/' . strtolower(MANAGER_PATH) . '_footer' : SITEC . '/footer';

        $this->data['header'] = strtolower(MANAGER_PATH) . '_header';
        $this->data['footer'] = strtolower(MANAGER_PATH) . '_footer';
    }

    /**
     * 检查管理员是否登录， 未登录跳转到登录页面
     */
    public function checkAdminLogin()
    {
        if ($this->sitemethod != 'login' && $this->sitemethod != 'logout') {
            $this->admin_info = $this->session->userdata('admin_info');
            if (empty($this->admin_info['id'])) {
                redirect_manager('admin/login');
            }
        }
    }

    /**
     * 提示信息
     * @param string $err 输出信息
     * @param string $url 跳转到URL
     * @param int $sec 跳转秒数
     * @param int $is_right 是否是正确的时候显示的信息
     */
    public function message($err = '', $url = '', $sec = '1', $is_right = 0)
    {
        if ($err) {
            $this->data['sec'] = $sec * 1000;
            $this->data['url'] = ($url);
            $this->data['err'] = ($err);
            $this->load->view(MANAGER_PATH . '/message', $this->data);
        }
    }
}

/**
 * Class MY_Controller 前端主控制器
 */
class MY_Controller extends Common_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

}

/* 加载模块 主控制器*/
if (file_exists(MODULE_PATH . MODULE_CONTROLLER . '.php')) {
    require_once MODULE_PATH . MODULE_CONTROLLER . '.php';
}