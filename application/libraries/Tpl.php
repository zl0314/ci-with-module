<?php
/**
 * 自动加载模板
 * @author Aaron Zhang <nice5good@126.com>
 * @Date   : 2016-12-15
 */

class Tpl
{
    /**
     * @var CI_Controller
     */
    private $CI;
    /**
     * 站点控制器
     * @var
     */
    private $siteclass;
    /**
     * 站点执行的方法
     * @var
     */
    private $sitemethod;
    /**
     * 传递给模板的参数
     * @var array|null
     */
    private $data = [];
    /**
     * 模板文件
     * @var string
     */
    private $template_file = '';

    /**
     * 模板路径
     * @var string
     */
    private $template_dir = '';
    /**
     * 默认的控制器
     * @var string
     */
    private $default_class;
    /**
     * 后台模板路径
     * @var string
     */
    private $manager_path;

    /**
     * Tpl constructor.
     */
    public function __construct()
    {
        $this->CI = get_instance();
        $this->data = null;
        $this->default_class = 'Welcome';
        $this->manager_path = MANAGER_PATH;

        $this->template_dir = VIEWPATH;

        $this->template_file = !empty($this->CI->uri->segments[1])
            ? ucwords($this->CI->uri->segments[1])
            : ucwords($this->default_class);

        $this->template_file .= !empty($this->CI->uri->segments[2]) && (ucwords($this->CI->uri->segments[1]) == $this->manager_path)
            ? '/' . ucwords($this->CI->uri->segments[2])
            : (!empty($this->CI->uri->segments[2]) ? '/' . $this->CI->uri->segments[2] : '/' . $this->default_class);

        $this->template_file .= !empty($this->CI->uri->segments[3]) && (ucwords($this->CI->uri->segments[1]) == $this->manager_path)
            ? '/' . ($this->CI->uri->segments[3])
            : (!empty($this->CI->uri->segments[1]) && ucwords($this->CI->uri->segments[1]) == $this->manager_path ? '/' . $this->default_class : '');

    }


    /**
     * [给模板赋值]
     **/
    public function assign($tpl_var, $value = null)
    {
        if (is_array($tpl_var)) {
            foreach ($tpl_var as $k => $v) {
                $this->assign($k, $v);
            }

            return true;
        }
        $this->CI->data[$tpl_var] = $value;
    }

    /**
     * 加载模板
     *
     * @param string $template
     */
    public function display($template = null)
    {
        $this->init_tpl_dir($template);
        $template = $template ? $template : $this->template_file;

        $data = !empty($this->CI->data) ? $this->CI->data : [];

        //加载Header文件
        if (!empty($this->CI->data['header'])) {
            $this->CI->load->view($this->CI->data['header'], $data);
        }

        if (!empty($_GET['vue'])) {
            if (!empty($_GET['callback'])) {
                $json = json_encode($data);
                $callback = $_GET['callback'];
                echo $callback . '(' . $json . ')';
                exit;
            }
        }

        //加载内容文件
        $this->CI->load->view($template, $data);

        //加载Footer文件
        if (!empty($this->CI->data['footer'])) {
            $this->CI->load->view($this->CI->data['footer'], $data);
        }

    }

    /**
     * 创建模板目录以及模板文件
     */
    public function init_tpl_dir($template = '')
    {
        $siteclass = $this->CI->router->class;
        $sitemethod = $this->CI->router->method;

        $this->siteclass = $siteclass;
        $this->sitemethod = $sitemethod;

        //创建目录 以及 当前方法的文件
        $template = $template ? $template : $this->template_file;
        $template_file = $this->template_dir . $template . '.php';

        //得到模块的真实路径， 判断是否来自模块
        $ref = new ReflectionClass($this->siteclass);
        $source_file = $ref->getFileName();
        $is_from_module = strpos($source_file, MODULE_PATH) !== false;
        if ($is_from_module) {

            //模板路径
            $this->template_dir = MODULE_PATH
                . ucfirst($this->siteclass)
                . DIRECTORY_SEPARATOR
                . 'views' . DIRECTORY_SEPARATOR . $this->CI->router->directory
//                . DIRECTORY_SEPARATOR
                . ucfirst($this->siteclass);

            //模板文件
            $template_file = $this->template_dir
                . DIRECTORY_SEPARATOR
                . $this->sitemethod
                . '.php';

        }

        //创建目录
        if (!file_exists($template_file)) {
            creat_dir_with_filepath($template_file);
        }
        //重新设置模型模板路径
        if (file_exists($template_file) && $is_from_module) {
            $this->template_file = str_replace(MODULE_PATH, '', $template_file);
        }
        //创建以当前方法为文件名的文件
        if (!file_exists($template_file)) {
            $handle = @fopen($template_file, 'w');
            @fwrite($handle, '<?php' . "\r\n");
            @fclose($handle);
        }
    }


}