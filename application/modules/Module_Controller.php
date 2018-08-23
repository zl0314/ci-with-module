<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 21:49
 * FileName : Module_Controller.php
 */

class Module_Controller extends Common_Controller
{
    /**
     * Module_Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
        //模块名称
        define('CUR_MODULE_NAME', ucfirst(SITEC));
    }

    /**
     * 当请求控制器中的方法不存在的时候执行
     *
     * @param string $url_param_1 第一个参数，如：xxx.com/news/show/$url_param_1
     * @param array $dataArr 第二，三...N个参数， 都会放到这个数组里，如： xxx.com/news/show/$url_param1/1/2/3
     */
    public function _remap($url_param_1 = '', $dataArr = [])
    {
        //echo $url_param_1;
        // do something
    }


    /**
     * 表单提交， 进行信息合法性验证
     */
    public function FormValidation()
    {
        $validation_path = dirname(__FILE__) . '/' . $this->siteclass . '/validation/validation.php';
        if (file_exists($validation_path)) {
            include_once $validation_path;
            $fetch_config = 'front';
            if ($this->is_manager) {
                $fetch_config = 'manager';
            }
            $config = @$validation_config[$fetch_config];
            if (!empty($config)) {
                $this->form_validation->set_rules($config);
                $this->form_validation->set_error_delimiters('<p class="form_error">', '</p>');
                if ($this->form_validation->run() !== FALSE) {
                    return true;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

}