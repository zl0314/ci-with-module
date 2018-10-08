<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Roles extends Base_Controller
{
    public function __construct ()
    {
        $this->hasUpdated = true;
        $this->hasCreated = true;
        parent::__construct();
        $this->tb = 'roles';
        $this->listorder = 'id desc';
    }

}
        
        