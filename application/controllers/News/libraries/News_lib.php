<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/21 21:46
 * FileName : Test.php
 */

class News_lib extends BaseLib
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function ec ()
    {
        echo 'method is :' . __METHOD__;
    }
}