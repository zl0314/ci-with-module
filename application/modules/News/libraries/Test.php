<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/21 21:46
 * FileName : Test.php
 */

class Test extends BaseLib
{
    public function __construct ()
    {
        echo 'this is test __construct method';
    }

    public function ec ()
    {
        echo 'method is :' . __METHOD__;
    }
}