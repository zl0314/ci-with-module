<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Privileges extends Module_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->tb = 'privileges';

    }


}
        
        