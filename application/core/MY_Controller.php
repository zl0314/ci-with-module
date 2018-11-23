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

    /**
     * 表名
     * @var
     */
    public $tb = '';

    /**
     * @var 排序字段
     */
    public $listorder;

    /**
     * @var string 公众号APPID
     */
    public $wechat_appid;
    /**
     * @var string 公众号APPSEC
     */
    public $wechat_appsec;

    /**
     * @var string 公众号秘钥
     */
    public $wechat_token;

    /**
     * @var string 公众号aes加密串
     */
    public $wechat_aes_key;

    /**
     * @var string 小程序APPID
     */
    public $wechat_mini_p_appid;
    /**
     * @var string 小程序APPSEC
     */
    public $wechat_mini_p_appsec;


    public function __construct ()
    {
        parent::__construct();

        //判断是否是后台管理
        $uri_first = $this->uri->segment( 1 );
        if ( $uri_first == MANAGER_PATH ) {
            $this->is_manager = true;
        }

        $this->listorder = $this->primary . ' desc';

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
            'siteclass'      => $this->siteclass,
            'sitemethod'     => $this->sitemethod,
            'is_mobile'      => $this->is_mobile,
            'is_manager'     => $this->is_manager,
            'config'         => $this->_config,
            'wechat_appid'   => APPID,
            'wechat_appsec'  => APPSEC,
            'wechat_token'   => TK,
            'wechat_aes_key' => EK,

            'wechat_mini_p_appid'  => MINI_P_APPID,
            'wechat_mini_p_appsec' => MINI_P_APPSEC,

        ];
        $this->tpl->assign( $vars );

        $this->wechat_appid = APPID;
        $this->wechat_appsec = APPSEC;
        $this->wechat_token = TK;
        $this->wechat_aes_key = EK;
        $this->wechat_mini_p_appid = MINI_P_APPID;
        $this->wechat_mini_p_appsec = MINI_P_APPSEC;


        /**
         * 加载模块对应的模型
         */
        $this->isLoadModel();

        /**
         * 加载模块对应的语言包
         */
        $this->isLoadLang();
        /**
         * 自动加载类
         */
        $this->isLoadLibrary();
    }

    /**
     * 加载模块对应的模型
     */
    private function isLoadModel ()
    {

        $model_path = MODULE_PATH . $this->siteclass . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;
        $model_name = $this->siteclass . '_model';
        $model_file = $model_name . '.php';
        if ( file_exists( $model_path . $model_file ) ) {
            $this->load->model( $model_name );

            //赋予模型属性
            $this->model = $this->$model_name;
            $this->model->tb = $this->tb;
        }

    }

    /**
     * 加载模块对应的类
     */
    private function isLoadLibrary ()
    {
        $model_path = MODULE_PATH . $this->siteclass . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR;
        $model_name = $this->siteclass . '_lib';
        $model_file = $model_name . '.php';
        if ( file_exists( $model_path . $model_file ) ) {
            $this->load->library( $model_name, null, 'lib' );

            //赋予模型属性
            $this->lib->tb = $this->tb;
        }
    }

    /**
     * 多语言开关， 是否开户多语言
     */
    private function isLoadLang ()
    {
        if ( LANG_ON ) {
            $this->load->helper( 'language' );

            $lang_path = MODULE_PATH . $this->siteclass . DIRECTORY_SEPARATOR . 'language' . DIRECTORY_SEPARATOR . $this->_config['language'] . DIRECTORY_SEPARATOR;
            $lang_name = strtolower( $this->siteclass ) . '_lang';
            $lang_file = $lang_name . '.php';
            if ( file_exists( $lang_path . $lang_file ) ) {
                $this->lang->load( strtolower( $this->siteclass ) );
            }

            //加载公共语言包
            $lang = $this->_config['language'];
            if ( file_exists( APPPATH . 'language/' . $lang . '/public_lang.php' ) ) {
                $this->lang->load( 'public' );
            }
        }
    }

    //解密前端加密的数据
    public function parseEncryptData ()
    {
        $data = _post( 'data' );
        $this->load->library( 'Rsa' );
        $formData = $this->rsa->privateDecrypt( $data );
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
     *  是否检查 登录有效
     * @var bool
     */
    public $checkLogin = true;

    /**
     * 默认每页显示数量
     * @var int
     */
    public $pageNum = 10;

    /**
     * 是否有创建时间
     * @var bool
     */
    public $hasUpdated = false;
    /**
     * 是否有修改时间
     * @var bool
     */
    public $hasCreated = false;

    /**
     * 控制器对应的模型名
     * @var string
     */
    public $model = '';

    public function __construct ()
    {
        parent::__construct();
        if ( !in_array( $this->sitemethod, [ 'login', 'logout' ] ) ) {
            $this->checkAdminLogin();
        }
        $this->data['admin_info'] = $this->admin_info;
        $this->is_manager = true;

        //定义后台路径
        define( 'ADMIN_MANAGER_PATH', site_url( MANAGER_PATH . '/' . SITEC ) ); //只到当前控制器
        define( 'ADMIN_MANAGER_FULL_PATH', site_url( MANAGER_PATH . '/' . SITEC . '/' . SITEM ) ); // 到控制器下面的方法

        $this->data['header'] = strtolower( MANAGER_PATH ) . '_header';
        $this->data['footer'] = strtolower( MANAGER_PATH ) . '_footer';

        //当前菜单的信息--到siteclass
        $this->data['curMenu'] = $this->menu->getMenuInfo( $this->siteclass, 'index' );

        $this->load->library( 'Systemlog' );
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
        $this->admin_info = $this->session->userdata( 'admin_info' );
        $this->data['myMenus'] = $this->menu->treePermisstionsBySubMenus();
        if ( empty( $this->admin_info['id'] ) ) {
            redirect_manager( 'Admin/login' );
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
            $this->data['url'] = ( $url ? $url : HTTP_REFERER );
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

    /**
     * 查询的字段
     * @return string
     */
    public function getField ()
    {
        return '*';
    }

    /**
     * 创建时，默认的数据
     *
     * @param string $variable
     * @param  array $data
     */
    public function getInitData ( $variable = '', $data = [] )
    {
        $assign_var = $variable ? $variable : 'model';
        $this->tpl->assign( $assign_var, $data );
    }

    public function index ()
    {
        $where = $this->getWhere();
        $field = $this->getField();
        //获取管理员总数
        $data = get_page( $this->tb, $where, $this->pageNum, $field, $this->listorder );

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
        $data = $this->session->flashdata( 'flash_post' );
        $this->getInitData( 'model', $data );
        $this->tpl->display( 'form' );
    }

    /**
     * 保存
     */
    public function store ()
    {
        $data = $this->getData();
        //数据检查
        $result = $this->FormValidation();
        if ( $result ) {
            if ( !empty( $this->hasCreated ) ) {
                $created_at = !empty( $data['data']['created_at'] ) ? $data['data']['created_at'] : date( 'Y-m-d H:i:s' );
                $data['data']['created_at'] = $created_at;
            }
            $saveResult = $this->rs_model->save( $this->tb, $data['data'] );
            if ( $saveResult ) {
                $success = true;
                $msg = '添加成功， ID：' . $saveResult;
                $this->systemlog->saveLog( $msg, $success );

                $this->saveCallback( $saveResult, $data['data'] );
                $this->success_message( '保存成功', ADMIN_MANAGER_PATH );
            } else {
                $success = false;
                $msg = '表单验证通过，添加失败';
                $this->systemlog->saveLog( $msg, $success );

                $this->message( '保存失败' );
            }
        } else {
            $success = false;
            $msg = '表单验证未通过';
            $this->systemlog->saveLog( $msg, $success );

            //验证不通过，跳转， 并把错误信息和提交时的数据放入session_flash中，
            $errors = $this->form_validation->error_string();
            $this->session->set_flashdata( 'errors', $errors );
            $this->session->set_flashdata( 'flash_post', $data['data'] );
            redirect( ADMIN_MANAGER_PATH . '/create' );
        }


    }

    /** 编辑表单
     *
     * @param $id ID
     */
    public function edit ()
    {
        $this->getRow();
        if ( !empty( _post() ) ) {
            $this->update();
        }
        $this->tpl->display( 'form' );
    }

    /** 更新
     *
     * @param $id ID
     */
    public function update ()
    {
        $this->getRow();
        $id = _get( 'id' );

        $data = $this->getData();

        //数据检查
        $result = $this->FormValidation();

        if ( $result ) {
            if ( !empty( $this->hasUpdated ) ) {
                $created_at = !empty( $data['data']['updated_at'] ) ? $data['data']['updated_at'] : date( 'Y-m-d H:i:s' );
                $data['data']['updated_at'] = $created_at;
            }
            if ( empty( $data[ $this->primary ] ) ) {
                $data['data'][ $this->primary ] = _get( $this->primary );
            }
            $saveResult = $this->rs_model->save( $this->tb, $data['data'] );
            if ( $saveResult ) {
                $this->systemlog->saveLog( '修改成功，修改的ID：' . $saveResult );

                $this->saveCallback( $saveResult, $data['data'] );
                $this->success_message( '保存成功', ADMIN_MANAGER_PATH );
            } else {
                $this->systemlog->saveLog( '修改失败，修改的ID：' . $saveResult );
                $this->message( '保存失败' );
            }
        } else {
            //验证不通过，跳转， 并把错误信息和提交时的数据放入session_flash中，
            $errors = $this->form_validation->error_string();
            $this->session->set_flashdata( 'errors', $errors );
            $this->session->set_flashdata( 'flash_post', $data['data'] );
            $this->systemlog->saveLog( '提交修改时， 表单验证失败', false );

            redirect( ADMIN_MANAGER_PATH . '/edit?id=' . $id );
        }
    }

    /**
     * 根据主键得到记录值
     *
     * @param  $id 主键ID
     */
    public function getRow ()
    {
        $flashData = $this->session->flashdata( 'flash_post' );
        $model = [];
        if ( !empty( $flashData ) ) {
            $this->tpl->assign( [ 'model' => $flashData ] );
        } else {
            $id = intval( _get( $this->primary ) );
            if ( $id ) {
                $model = $this->rs_model->getRow( $this->tb, '*', [ $this->primary => $id ] );
                if ( empty( $model[ $this->primary ] ) ) {
                    $this->systemlog->saveLog( '修改时， 查找的记录不存在， ID：' . $id, false );
                    $this->message( '信息不存在 ' );
                } else {
                    if ( !empty( $this->model ) ) {
                        $this->model->attributes = $model;
                    }
                }
            }

            $this->tpl->assign( [ 'model' => $model ] );
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
                $this->systemlog->saveLog( '批量删除成功，ID：' . $data['id'] );
                $this->deleteCallback( $ids );

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
    public function public_listorder ()
    {
        $data = _post( 'listorder' ) ? _post( 'listorder' ) : [];
        if ( $data ) {
            foreach ( $data as $k => $v ) {
                $data = [ 'listorder' => !empty( $v ) ? $v : 0 ];
                $where = [ $this->primary => $k ];
                $this->rs_model->update( $this->tb, $where, $data );
            }

            $this->systemlog->saveLog( '批量排序成功' );

            $this->success_message( '排序成功', HTTP_REFERER );
        } else {
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
    public function saveCallback ( $result, $data = [] )
    {

    }

    /**
     * 删除成功之后调用
     *
     * @param $result
     *
     * @return mixed
     */
    public function deleteCallback ( $result )
    {

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
            $this->data['url'] = ( $url ? $url : HTTP_REFERER );
            $this->data['err'] = ( $err );
            $this->data['type'] = $is_right ? 'success' : 'fail';
            if ( isAjax() ) {
                $type = $this->data['type'];
                $type( $err );
            } else {
                $this->load->view( 'message', $this->data );
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
     * 根据主键得到记录值
     *
     * @param  $id 主键ID
     */
    public function getRow ( $id = '' )
    {
        $model = [];
        $id = !empty( _get( $this->primary ) ) ? intval( _get( $this->primary ) ) : $id;
        $where[ $this->primary ] = $id;

        if ( $id ) {
            $model = $this->rs_model->getRow( $this->tb, '*', $where );
            if ( empty( $model[ $this->primary ] ) ) {
                $this->message( '信息不存在 ' );
            } else {
                if ( !empty( $this->model ) ) {
                    $this->model->attributes = $model;
                }
            }
        }
        $this->tpl->assign( [ 'model' => $model ] );
    }

}

