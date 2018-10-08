<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Banners extends Base_Controller
{
    public function __construct ()
    {
        $this->hasCreated = true;
        $this->hasUpdated = true;
        parent::__construct();
        $this->tb = 'banners';
        $this->listorder = 'listorder desc, id desc';
    }

}