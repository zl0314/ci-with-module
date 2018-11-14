<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 22:44
 * FileName : MY_Router.php
 */

class MY_Router extends CI_Router
{
    public $is_manager;

    public function __construct ()
    {
        //默认方法
        $this->method = 'index';
        $this->is_manager = false;
        parent::__construct();

        $class_index = 1;
        $method_index = 2;

        //如果是后台管理， 对class method 重新赋值
        if ( !empty( $this->uri->segments[1] ) && ucwords( $this->uri->segments[1] ) == MANAGER_PATH ) {
            $this->is_manager = true;
            //$this->class = !empty( $this->uri->segments[2] )
            //    ? ucwords( $this->uri->segments[2] )
            //    : ( !empty( $this->uri->segments[1] ) ? $this->uri->segments[1] : 'Welcome' );
            //
            //$this->method = !empty( $this->uri->segments[3] )
            //    ? strtolower( $this->uri->segments[3] )
            //    : 'index';
            $this->directory = !empty( $this->uri->segments[1] ) && ucwords( $this->uri->segments[1] ) == MANAGER_PATH ? MANAGER_PATH . '/' : '';

            $class_index = 2;
            $method_index = 3;
        }

        //控制器进行路由以后，
        if ( !empty( $this->uri->rsegments[ $class_index ] ) ) {
            if ( !empty( $this->uri->segments[ $class_index ] ) && !empty( $this->uri->rsegments[ $class_index ] ) ) {
                if ( $this->uri->segments[ $class_index ] != $this->uri->rsegments[ $class_index ] ) {
                    $this->set_class( $this->uri->rsegments[ $class_index ] );
                    $this->class = $this->uri->rsegments[ $class_index ];
                } else {
                    $this->set_class( $this->uri->segments[ $class_index ] );
                    $this->class = $this->uri->segments[ $class_index ];
                }
            }
        }


        //方法进行路由以后，
        if ( !empty( $this->uri->rsegments[ $method_index ] ) ) {
            if ( !empty( $this->uri->segments[ $method_index ] ) && !empty( $this->uri->rsegments[ $method_index ] ) ) {
                if ( $this->uri->segments[ $method_index ] != $this->uri->rsegments[ $method_index ] ) {
                    $this->set_method( $this->uri->rsegments[ $method_index ] );
                    $this->method = $this->uri->rsegments[ $method_index ];
                } else {
                    $this->set_method( $this->uri->segments[ $method_index ] );
                    $this->method = $this->uri->segments[ $method_index ];
                }
            }
        }

        //默认的方法
        if ( empty( $this->uri->segments[ $class_index ] ) && empty( $this->uri->segments[ $method_index ] ) ) {
            $this->set_method( 'index' );
            $this->method = 'index';
        } else if ( $this->is_manager && empty( $this->uri->segments[ $method_index ] ) ) {
            $this->set_method( 'index' );
            $this->method = 'index';

        }

    }

}