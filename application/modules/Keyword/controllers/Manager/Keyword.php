<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Keyword extends Base_Controller
{
    public function __construct ()
    {
        $this->tb = 'keyword';
        $this->listorder = 'id desc';

        parent::__construct();

    }


}
        
        