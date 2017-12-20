#CI VERSION 3.1.6

#1、添加常量,在application/config/constanst.php文件末尾添加

	define( 'MANAGER_PATH', 'Manager' );
	define( 'MODULE_NAME', 'modules' );
    define( 'MODULE_PATH', APPPATH . MODULE_NAME . DIRECTORY_SEPARATOR );
    define( 'MODULE_CONTROLLER', 'Module_Controller' );
	
# 2、增加application/core/MY_Loader.php
	
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
		protected $_ci_view_paths = [ VIEWPATH => true, MODULE_PATH => false ];

		public function __construct ()
		{
			parent::__construct();
		}

		public function initialize ()
		{
			parent::initialize();
		}
	}
	
#3、修改system/core/CodeIgniter.php 
   
	>>> 找到如果代码：
        if(empty($class) OR !file_exists(MODULE_PATH . $class . '/controllers/'.$RTR->directory.$class.'.php')){
            $e404 = TRUE;
        }
	>>> 在后面添加如下代码：
        if(file_exists(MODULE_PATH . $class . '/controllers/'.$RTR->directory.$class.'.php')){
            $e404 = false;
            require_once(MODULE_PATH . $class . '/controllers/'.$RTR->directory.$class.'.php');
            if(!method_exists($class, $method)){
                $params = array($method, array_slice($URI->rsegments, 2));
                $method = '_remap';
            }
        }
	
	
#4、增加类文件 

文件 application/libraries/Tpl.php