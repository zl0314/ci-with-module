<?php

/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2018/1/26
 * Time: 14:16
 */
class Adminuser extends Base_Controller
{
    public $statusArr;

    public function __construct ()
    {
        parent::__construct();
        $this->checkAdminLogin();

        $this->tb = 'adminuser';

        $this->statusArr = [
            '0' => '正常',
            '1' => '锁定',
        ];
        $this->tpl->assign( 'statusArr', $this->statusArr );
    }


}
