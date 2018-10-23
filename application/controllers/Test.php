<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/10/23 19:47
 * FileName : Test.php
 */
class Test extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function index ()
    {
        echo __METHOD__;
    }
}