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
        //表名
        $this->tb = 'news';
        //主键
        $this->primary = 'id';
        //创建时间
        $this->hasCreated = true;
        //更新时间
        $this->hasUpdated = true;

        parent::__construct();
    }

}