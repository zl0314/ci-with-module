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
    /**
     * @var string 默认主键
     */
    public $primary = 'id';

    public function __construct ()
    {
        parent::__construct();

        //判断是否是后台管理
        $uri_first = $this->uri->segment( 1 );
        if ( $uri_first == MANAGER_PATH ) {
            $this->is_manager = true;
        }

        $config = $this->config->config;
        $this->_config = $config;

        $this->siteclass = $this->router->class;
        $this->sitemethod = $this->router->method;

        /**
         * 当前控制器
         */
        define( 'SITEC', ucfirst( $this->siteclass ) );
        /**
         * 当前的方法
         */
        define( 'SITEM', ucfirst( $this->sitemethod ) );


        /**
         * 判断是否是微信
         */
        if ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false ) {
            $this->is_wechat = true;
        }

        /**
         * 判断是否是手机端
         */
        $this->is_mobile = $this->ua->is_mobile;

        /**
         * 配置项
         */
        $config = $this->config->config;
        $this->_config = $config;

        $vars = [
            'siteclass'  => $this->siteclass,
            'sitemethod' => $this->sitemethod,
            'is_mobile'  => $this->is_mobile,
            'is_manager' => $this->is_manager,
            'config'     => $this->_config,
        ];
        $this->tpl->assign( $vars );
    }

    //解密前端加密的数据
    public function parseEncryptData ()
    {
        $data = _post( 'data' );
        $rsa = $this->load->library( 'Rsa' );
        $rsa = new Rsa();
        $formData = $rsa->privateDecrypt( $data, $this->_config['rsa_private_key'] );
        parse_str( $formData, $result );

        return $result;
    }

}


/* 加载模块 主控制器*/
if ( file_exists( MODULE_PATH . MODULE_CONTROLLER . '.php' ) ) {
    require_once MODULE_PATH . MODULE_CONTROLLER . '.php';
}


/**
 * Class Base_Controller 后端主控制器
 */
class Base_Controller extends Module_Controller
{
    /**
     * 登录的管理员信息
     */
    public $admin_info;
    /**
     * 表名
     * @var
     */
    public $tb;

    public function __construct ()
    {
        parent::__construct();
        $this->checkAdminLogin();

        $this->admin_info = $this->session->userdata( 'admin_info' );
        $this->data['admin_info'] = $this->admin_info;

        //定义后台路径
        define( 'ADMIN_MANAGER_PATH', site_url( MANAGER_PATH . '/' . SITEC ) ); //只到当前控制器
        define( 'ADMIN_MANAGER_FULL_PATH', site_url( MANAGER_PATH . '/' . SITEC . '/' . SITEM ) ); // 到控制器下面的方法

        //定义头尾文件
//        $this->data['header'] = $this->is_manager ? SITEC . '/' . strtolower(MANAGER_PATH) . '_header' : SITEC . '/header';
//        $this->data['footer'] = $this->is_manager ? SITEC . '/' . strtolower(MANAGER_PATH) . '_footer' : SITEC . '/footer';

        $this->data['header'] = strtolower( MANAGER_PATH ) . '_header';
        $this->data['footer'] = strtolower( MANAGER_PATH ) . '_footer';
    }

    /**
     * 检查管理员是否登录
     *
     * @param bool $toLogin 是否跳转到登录页
     *
     * @return boolean
     */
    public function checkAdminLogin ()
    {
        if ( $this->sitemethod != 'login' && $this->sitemethod != 'logout' ) {
            $this->admin_info = $this->session->userdata( 'admin_info' );
            if ( empty( $this->admin_info['id'] ) ) {
                redirect_manager( 'Admin/login' );
            }
        }
    }

    /**
     * 跳转提示信息 错误
     *
     * @param string $err      输出信息
     * @param string $url      跳转到URL
     * @param int    $sec      跳转秒数
     * @param int    $is_right 是否是正确的时候显示的信息
     */
    public function message ( $err = '', $url = '', $sec = '1', $is_right = false )
    {
        if ( $err ) {
            $this->data['sec'] = $sec * 1000;
            $this->data['url'] = ( $url );
            $this->data['err'] = ( $err );
            $this->data['type'] = $is_right ? 'success' : 'fail';
            if ( isAjax() ) {
                $type = $this->data['type'];
                $type( $err );
            } else {
                $this->load->view( MANAGER_PATH . '/message', $this->data );
            }
        }
    }

    /**
     * 跳转提示信息 成功
     *
     * @param string $err      输出信息
     * @param string $url      跳转到URL
     * @param int    $sec      跳转秒数
     * @param int    $is_right 是否是正确的时候显示的信息
     */
    public function success_message ( $err = '', $url = '', $sec = '1', $is_right = true )
    {
        $this->message( $err, $url, $sec, $is_right );
    }

    /**
     * 获取条件
     * @return array
     */
    public function getWhere ()
    {
        return [];
    }

    /**
     * 赋值
     * @return array
     */
    public function getVars ()
    {
        return [];
    }

    public function index ()
    {
        $where = $this->getWhere();
        //获取管理员总数
        $data = get_page( $this->tb, $where );
        $vars = $this->getVars();
        $this->tpl->assign( $vars );
        $this->tpl->assign( $data );
        $this->tpl->display();
    }

    /**
     * 创建表单
     */
    public function create ()
    {
        if ( !empty( _post() ) ) {
            $this->store();
        }
    }

    /**
     * 保存
     */
    public function store ()
    {
        $data = $this->getData();
        $result = $this->rs_model->save( $this->tb, $data );
        if ( $result ) {
            $this->saveCallback( $result );
            $this->success_message( '保存成功' );
        } else {
            $this->message( '保存失败' );
        }
    }

    /** 编辑表单
     *
     * @param $id ID
     */
    public function edit ( $id )
    {
        if ( !empty( _post() ) ) {
            $this->update( $id );
        }
    }

    /** 更新
     *
     * @param $id ID
     */
    public function update ( $id )
    {
        $data = $this->getData();
        $result = $this->rs_model->save( $this->tb, $data );
        if ( $result ) {
            $this->saveCallback( $result );
            $this->success_message( '保存成功' );
        } else {
            $this->message( '保存失败' );
        }
    }

    /**
     * 单个删除
     */
    public function delete ()
    {
        $this->commonDelete();
    }

    /**
     * 批量删除
     */
    public function batch_delete ()
    {
        $this->commonDelete();
    }

    /**
     * 公共删除方法
     */
    public function commonDelete ()
    {
        $data = $this->parseEncryptData();

        if ( !empty( $data ) ) {
            //删除方法
            $ids = explode( ',', $data['id'] );
            $res = false;
            if ( !empty( $ids ) ) {
                foreach ( $ids as $k => $id ) {
                    $where = [ $this->primary => $id ];
                    $res = $this->rs_model->delete( $this->tb, $where );
                }

                $this->success_message( '删除成功', HTTP_REFERER );
            }
        }
    }

    /**
     * [批量排序]
     * @$primary_key 主键
     * $order_field 排序字段
     * @date 2015-5-12
     **/
    public function commonListOrder ( $order_field = 'listorder' )
    {
        $data = _post( 'listorder' ) ? _post( 'listorder' ) : [];
        if ( $data ) {
            foreach ( $data as $k => $v ) {
                $data = [ $order_field => !empty( $v ) ? $v : 0 ];
                $where = [ $this->primary => $k ];
                $this->rs_model->update( $this->tb, $where, $data );
            }
            $this->success_message( '排序成功', HTTP_REFERER );
        }
    }

    /**
     * 保存前的操作 && 重新改变保存数据
     * @return array
     */
    public function getData ()
    {
        return _post();
    }

    /**
     * 保存成功之后调用
     *
     * @param $result
     *
     * @return mixed
     */
    public function saveCallback ( $result )
    {
        return $result;
    }
}

/**
 * Class MY_Controller 前端主控制器
 */
class MY_Controller extends Module_Controller
{

    public function __construct ()
    {
        parent::__construct();
    }

}

