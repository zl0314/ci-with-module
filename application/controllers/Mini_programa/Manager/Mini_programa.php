<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Mini_programa extends Base_Controller
{
    public function __construct ()
    {
        $this->tb = 'mini_programa';
        $this->listorder = 'id desc';

        parent::__construct();

    }

    public function index ()
    {
        $vars = [];
        $this->tpl->assign( $vars );
        $this->tpl->display();
    }
}
        
        