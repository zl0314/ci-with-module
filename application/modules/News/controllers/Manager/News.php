<?php

/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 20:30
 * FileName : controllers.php
 */
class News extends Base_Controller
{

    public function __construct ()
    {
        parent::__construct();
    }

    public function index ()
    {
        $this->tpl->display();
    }
}