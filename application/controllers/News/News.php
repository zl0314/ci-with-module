<?php

/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 20:30
 * FileName : controllers.php
 */
class News extends MY_Controller
{

    public function __construct ()
    {
        $this->tb = 'news';
        $this->primary = 'id';

        parent::__construct();
    }

    public function index ( $c = '' )
    {
        $this->lib->ec();
        $this->tpl->display();
    }

    public function show ( $id = '' )
    {
        $this->getRow( $id );
        echo $this->model->getContentAttribute();
    }


}