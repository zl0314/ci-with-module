<?php

/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2018/1/26
 * Time: 14:16
 */
class Adminuser extends Module_Controller
{
    public $statusArr;

    public function __construct()
    {
        parent::__construct();
        $this->statusArr = [
            '0' => '正常',
            '1' => '锁定'
        ];
        $this->tpl->assign('statusArr', $this->statusArr);
    }

    public function index()
    {
        //获取管理员总数
        $data = get_page('adminuser', []);
        $vars = [];
        $this->tpl->assign($vars);
        $this->tpl->assign($data);
        $this->tpl->display();
    }

    public function add()
    {

    }

    public function edit()
    {

    }

}
