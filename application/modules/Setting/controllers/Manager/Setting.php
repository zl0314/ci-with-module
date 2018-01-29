<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Base_Controller
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
            if ($result) { //保存数据
                $data = _post('data');
                if (empty($data['id'])) {
                    $data['id'] = null;
                }
                $this->rs_model->save('system_setting', ['id' => $data['id'], 'setting' => json_encode($data)]);
                $this->message('保存成功', (ADMIN_MANAGER_FULL_PATH));
            }
        }

        //读取数据
        $setting = $this->rs_model->getRow('system_setting', '*');

        $vars = [
            'setting' => json_decode($setting['setting'], 1)
        ];

        $this->tpl->assign($vars);
        $this->tpl->display();
    }

}
