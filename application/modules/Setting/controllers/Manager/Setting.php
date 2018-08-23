<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends Base_Controller
{
    public $mail_model;
    public $system_setting_model;

    public function __construct()
    {
        parent::__construct();
        $this->checkAdminLogin();
        $this->tb = 'settings';
    }


}
