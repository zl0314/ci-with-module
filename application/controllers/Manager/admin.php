<?php

/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 23:13
 * FileName : admin.php
 */
class Admin extends Base_Controller
{
    public $_config;

    public function __construct()
    {
        parent::__construct();
        $config = $this->config->config;
        $this->_config = $config;
    }

    public function index()
    {

    }

    public function login()
    {
        if (!empty($_POST)) {
            $captcha = _post('captcha');

            $this->load->library('Rsa');
            $rsa = new Rsa();
            $decrypt_data = $rsa->privateDecrypt(_post('data'), $this->_config['rsa_private_key']);
            if (!$decrypt_data) {
                $this->message('信息被篡改，请重试', site_url('admincp/login'));
            }
            parse_str($decrypt_data, $form_data);
            $_POST = $form_data;
            $username = _post('username');
            $password = _post('password');

            if (strtolower($this->session->userdata('captcha')) != strtolower($captcha)) {
                $this->message('验证码不正确', manager_url($this->siteclass . '/' . $this->sitemethod));
            }
            if (empty($username)) {
                $this->message('用户名不能为空', manager_url($this->siteclass . '/' . $this->sitemethod));
            }
            if (empty($password)) {
                $this->message('密码不能为空', manager_url($this->siteclass . '/' . $this->sitemethod));
            }
            $admin_info = $this->Result_model->getRow('admin_user', '*', array('user_name' => $username));

            if (empty($admin_info)) {
                $this->message('用户名或密码错误', manager_url($this->siteclass . '/' . $this->sitemethod));
            }

            $hash_password = password_hash($password, PASSWORD_BCRYPT);;
            if (!password_verify($password, $admin_info['password'])) {
                $this->message('用户名或密码错误', manager_url($this->siteclass . '/' . $this->sitemethod));
            }

            if ($admin_info['status'] == 0) {
                $this->message('用户被禁用，请联系管理员');
            }

            //更新最后登录时间
            $where = array(
                'user_id' => $admin_info['user_id']
            );
            $data = array(
                'last_login_time' => date('Y-m-d H:i:s')
            );
            $admin_info['last_login_time'] = $data['last_login_time'];
            $this->Result_model->update('admin_user', $where, $data);

            unset($admin_info['password']);
            unset($admin_info['addtime']);
            unset($admin_info['last_login_time']);
            $this->session->set_userdata('admin_info', $admin_info);
            $this->message('登录成功', manager_url($this->siteclass . '/index'));
        }
        $this->tpl->display();
    }
}