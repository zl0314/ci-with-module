<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Module_Controller
{
    public $mail_model;
    public $system_setting_model;

    public function __construct()
    {
        parent::__construct();
        $this->checkAdminLogin();
    }

    public function index()
    {
        $this->load->model('system_setting_model');
        if (!empty($_POST)) {
            //表单验证
            $result = $this->FormValidation();
            if ($result) {
                $data = _post('data');

                if ($data['id'] == '') {
                    $data['id'] = null;
                }
                $this->system_setting_model->saveData($data);
                $this->jump('保存成功', site_url($this->siteclass . '/' . $this->sitemethod));
            }
        }
        $setting = $this->rs_model->getRow('system_setting', '*');

        $vars = [
            'setting' => json_encode($setting, 1)
        ];
        $this->tpl->assign($vars);
        $this->tpl->display();
    }

}
