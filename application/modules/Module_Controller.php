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
    public function __construct ()
    {
        parent::__construct();
    }

    /**
     * 当请求控制器中的方法不存在的时候执行
     *
     * @param string $url_param_1 第一个参数，如：xxx.com/news/show/$url_param_1
     * @param array  $dataArr     第二，三...N个参数， 都会放到这个数组里，如： xxx.com/news/show/$url_param1/1/2/3
     */
    public function _remap ( $url_param_1 = '', $dataArr = [] )
    {
        echo $url_param_1;
        // do something
    }

}