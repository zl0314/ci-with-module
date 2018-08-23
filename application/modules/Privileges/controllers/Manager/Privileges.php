<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Privileges extends Base_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function getWhere ()
    {
        $where = [
            'parent_id' => 0,
            'show_at'   => 0,
        ];

        return $where;
    }
}