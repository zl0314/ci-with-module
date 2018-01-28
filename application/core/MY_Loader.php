<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 22:25
 * FileName : MY_Loader.php
 */

class MY_Loader extends CI_Loader
{
    /**
     * List of paths to load views from
     * @var    array
     */
    protected $_ci_view_paths = [];

    /**
     * List of paths to load libraries from
     * @var    array
     */
    protected $_ci_library_paths = [];

    /**
     * List of paths to load models from
     * @var    array
     */
    protected $_ci_model_paths = [];

    /**
     * List of paths to load helpers from
     * @var    array
     */
    protected $_ci_helper_paths = [];

    public function __construct()
    {
        parent::__construct();
        $CI = &get_instance();
        $class = ucfirst($CI->router->class);

        //重新定义视图路径， VIEWPATH + MODULE_PATH
        $this->_ci_view_paths = [VIEWPATH => true, MODULE_PATH => true];

        //重新定义Helper路径， VIEWPATH + BASEPATH + MODULE_PATH
        $this->_ci_helper_paths = [APPPATH, BASEPATH, MODULE_PATH . $class . '/'];

        //重新定义类路径， VIEWPATH + BASEPATH + MODULE_PATH
        $this->_ci_library_paths = [APPPATH, BASEPATH, MODULE_PATH . $class . '/'];

        //重新定义模型路径， VIEWPATH + MODULE_PATH
        $this->_ci_model_paths = [APPPATH, MODULE_PATH . $class . '/'];

    }

    public function initialize()
    {
        parent::initialize();
    }
}