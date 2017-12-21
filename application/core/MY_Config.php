<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/21 21:52
 * FileName : MY_Config.php
 */

class MY_Config extends CI_Config
{
    public $_config_paths = [];

    public function __construct ()
    {
        parent::__construct();
        $this->_config_paths = [ APPPATH, MODULE_PATH ];
    }
}