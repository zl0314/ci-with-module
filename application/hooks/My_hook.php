<?php

class My_hook
{
    public $CI;

    public function __construct ()
    {
        $this->CI = get_instance();
    }

    /**
     * 所有加载项目全部加载，执行权限检查
     */
    public function pre_controller ( $arg = [] )
    {
        if ( empty( $this->CI->is_manager ) ) {
            return true;
        }
        if ( $this->CI->admin_info['is_super'] == 1 ) {
            return;
        }
        if ( !in_array( $this->CI->data['siteclass'], [ 'Captcha', 'Admin' ] )
            && !in_array( $this->CI->data['sitemethod'], [ 'login', 'logout' ] ) ) {
            $menu = $this->CI->menu->getMenuKeyBySiteclass();
            if ( isset( $menu[ $this->CI->data['siteclass'] ] ) ) {
                if ( !isset( $menu[ $this->CI->data['siteclass'] ][ $this->CI->data['sitemethod'] ] ) ) {
                    $this->CI->message( '您没有权限访问，请联系管理员' );
                }
            } else {
                $this->CI->message( '您没有权限访问，请联系管理员' );
            }
        }

    }

    /**
     * 挂在在 post_system 的钩子 （在最终的页面发送到浏览器之后、在系统的最后期被调用。）
     *
     * @param array $arg
     */
    public function system_end ( $arg = [] )
    {
        $GLOBALS['system_end_time'] = microtime();

    }

}