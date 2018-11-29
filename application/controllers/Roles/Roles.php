<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Roles extends Module_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function index ()
    {
        $vars = [];
        $this->tpl->assign( $vars );
    }
}
        
        