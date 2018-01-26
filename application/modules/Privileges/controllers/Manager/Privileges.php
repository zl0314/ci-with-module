<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges extends Module_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $where = [
            'parent_id' => 0,
            'show_at' => 0
        ];
        $data = get_page('privileges', $where, 15);
        $vars = [];
        $this->tpl->assign($vars);
        $this->tpl->assign($data);
        $this->tpl->display();
    }

    public function add()
    {
        $vars = [];
        $this->tpl->assign($vars);
        $this->tpl->display();
    }
}