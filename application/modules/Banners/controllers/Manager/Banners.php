<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Banners extends Base_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->tb = 'banners';
        $this->listorder = 'id desc';
    }

    public function index ()
    {
        $vars = [];
        $this->tpl->assign( $vars );
        $this->tpl->display();
    }
}
        
        