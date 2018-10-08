<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 22:44
 * FileName : MY_Router.php
 */

class MY_Router extends CI_Router
{
    public function __construct ()
    {
        parent::__construct();

        //如果是后台管理， 对class method 重新赋值
        if ( !empty($this->uri->segments[1]) &&  ucwords( $this->uri->segments[1] ) == MANAGER_PATH ) {
            $this->class = !empty( $this->uri->segments[2] )
                ? ucwords( $this->uri->segments[2] )
                : ( !empty( $this->uri->segments[1] ) ? $this->uri->segments[1] : 'Welcome' );

            $this->method = !empty( $this->uri->segments[3] )
                ? strtolower( $this->uri->segments[3] )
                : 'index';
            $this->directory = !empty( $this->uri->segments[1] ) && ucwords( $this->uri->segments[1] ) == MANAGER_PATH ? MANAGER_PATH . '/' : '';
        } else {
            $this->method = !empty( $this->uri->segments[2] )
                ? strtolower( $this->uri->segments[2] )
                : 'index';
        }

    }

}