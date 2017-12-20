<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 22:44
 * FileName : MY_Router.php
 */

class MY_Router extends CI_Router
{
    public function __construct ()
    {
        parent::__construct();

        $class = $this->class;
    }

}