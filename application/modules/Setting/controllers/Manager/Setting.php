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
            $data = request_post('data');
            if ($data['id'] == '') {
                $data['id'] = null;
            }
            $this->system_setting_model->saveData($data);
            cache_write('system_setting', ($data));
            $this->jump('保存成功', site_url($this->siteclass . '/' . $this->sitemethod));
        }
        $this->data['setting'] = $this->rs_model->getRow('system_setting','*');
        $this->tpl->display();
    }

}
