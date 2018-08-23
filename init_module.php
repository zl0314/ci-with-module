<?php

include_once 'application/helpers/common_helper.php';


if (!empty($argv['1'])) {
    $module_path = 'application/modules/';
    $module_name = ucfirst($argv[1]);

    //后台
    $module_dir = $module_path . $module_name . '/controllers/Manager/' . $module_name . '.php';
    $module_view_dir = $module_path . $module_name . '/views/Manager/' . $module_name . '/index.php';
    if (!file_exists($module_dir)) {
        creat_dir_with_filepath($module_dir);
        file_put_contents($module_dir, '<?php ' . "\r\n" . '
        defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

        class ' . $module_name . ' extends Module_Controller
        {
            public function __construct()
            {
                parent::__construct();
            }
        
            public function index()
            {
                $vars = [];
                $this->tpl->assign($vars);
                $this->tpl->display();
            }
        }
        
        ');
    }

    if (!file_exists($module_view_dir)) {
        creat_dir_with_filepath($module_view_dir);
        file_put_contents($module_view_dir, '<?php ');
    }


    //前台
    $module_dir = $module_path . $module_name . '/controllers/' . $module_name . '.php';
    $module_view_dir = $module_path . $module_name . '/views/' . $module_name . '/index.php';
    if (!file_exists($module_dir)) {
        creat_dir_with_filepath($module_dir);
        file_put_contents($module_dir, '<?php ' . "\r\n" . '
        defined(\'BASEPATH\') OR exit(\'No direct script access allowed\');

        class ' . $module_name . ' extends Module_Controller
        {
            public function __construct()
            {
                parent::__construct();
            }
        
            public function index()
            {
                $vars = [];
                $this->tpl->assign($vars);
            }
        }
        
        ');
    }

    if (!file_exists($module_view_dir)) {
        creat_dir_with_filepath($module_view_dir);
        file_put_contents($module_view_dir, '<?php ');
    }


}