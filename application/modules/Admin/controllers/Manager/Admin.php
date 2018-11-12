<?php

/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 23:13
 * FileName : admin.php
 */
class Admin extends Base_Controller
{
    public $_config;

    public function __construct ()
    {
        parent::__construct();
        $this->dontNeedAdd = true;
        $this->dontNeedDel = true;
    }

    public function index ()
    {
        $this->tpl->display();
    }

    public function login ()
    {

        $this->data['header'] = '';
        $this->data['footer'] = '';

        if ( !empty( $_POST ) ) {
            $captcha = _post( 'captcha' );

            $this->load->library( 'Rsa' );
            $decrypt_data = $this->rsa->privateDecrypt( _post( 'data' ), $this->_config['rsa_private_key'] );
            if ( !$decrypt_data ) {
                $this->message( lang( 'auth_fail' ), manager_url( 'Admin/login' ) );
            }
            parse_str( $decrypt_data, $form_data );
            $_POST = $form_data;
            $username = _post( 'username' );
            $password = _post( 'password' );

            if ( strtolower( $this->session->userdata( 'captcha' ) ) != strtolower( $captcha ) ) {
                $this->message( lang( 'captcha_error' ), manager_url( $this->siteclass . '/' . $this->sitemethod ) );
            }
            if ( empty( $username ) ) {
                $this->message( lang( 'user_name_not_empty' ), manager_url( $this->siteclass . '/' . $this->sitemethod ) );
            }
            if ( empty( $password ) ) {
                $this->message( lang( 'pwd_not_empty' ), manager_url( $this->siteclass . '/' . $this->sitemethod ) );
            }
            $admin_info = $this->rs_model->getRow( 'adminuser', '*', [ 'username' => $username ] );

            if ( empty( $admin_info ) ) {
                $this->message( lang( 'login_fail' ), manager_url( $this->siteclass . '/' . $this->sitemethod ) );
            }


            if ( !password_verify( $password, $admin_info['password'] ) ) {
                $this->message( lang( 'login_fail' ), manager_url( $this->siteclass . '/' . $this->sitemethod ) );
            }

            if ( $admin_info['status'] == 1 ) {
                $this->message( lang( 'user_disabled' ) );
            }

            //更新最后登录时间
            $where = [
                'id' => $admin_info['id'],
            ];
            $data = [
                'last_login_time' => date( 'Y-m-d H:i:s' ),
            ];
            $admin_info['last_login_time'] = $data['last_login_time'];
            $this->rs_model->update( 'adminuser', $where, $data );

            unset( $admin_info['password'] );
            unset( $admin_info['addtime'] );
            $this->session->set_userdata( 'admin_info', $admin_info );
            $this->success_message( lang( 'login_success' ), manager_url( $this->siteclass . '/index' ) );
        }
        $this->tpl->display();
    }

    public function logout ()
    {
        $this->checkLogin = false;

        $this->session->set_userdata( 'admin_info', '' );
        $this->session->sess_destroy();
        $this->success_message( lang( 'logout_success' ), ADMIN_MANAGER_PATH . '/login' );
    }
}