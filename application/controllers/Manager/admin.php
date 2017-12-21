<?php

/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 23:13
 * FileName : admin.php
 */
class Admin extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();

    }

    public function index ()
    {
        echo '123' . __FILE__;
    }
}