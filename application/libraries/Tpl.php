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
    public function __construct ()
    {
        $this->CI = &get_instance();
        $this->data = null;
        $this->default_class = 'index';
        $this->manager_path = MANAGER_PATH;

        //站点控制器和方法定义
        $siteclass = $this->CI->router->class;
        $sitemethod = $this->CI->router->method;
        $this->siteclass = $siteclass;
        $this->sitemethod = $sitemethod;


        $this->template_dir = $this->CI->inModule ? APPPATH . 'controllers/' . $this->siteclass . '/' : VIEWPATH;
        if ( $this->CI->is_manager ) {
            $this->template_dir .= 'views/Manager/';
        }
    }


    /**
     * [给模板赋值]
     **/
    public function assign ( $tpl_var, $value = null )
    {
        if ( is_array( $tpl_var ) ) {
            foreach ( $tpl_var as $k => $v ) {
                $this->assign( $k, $v );
            }

            return true;
        }
        $this->CI->data[ $tpl_var ] = $value;
    }

    /**
     * 加载模板
     *
     * @param string $template
     */
    public function display ( $template = null )
    {
        $this->init_tpl_dir( $template );

        $data = !empty( $this->CI->data ) ? $this->CI->data : [];

        //加载Header文件
        if ( !empty( $this->CI->data['header'] ) ) {
            $this->CI->load->view( $this->CI->data['header'], $data );
        }


        //加载内容文件
        $template = $template ?
            ( $this->CI->is_manager ? 'Manager/' . $template : $template ) :
            ( $this->CI->is_manager ? 'Manager/' . $this->sitemethod : $this->sitemethod );

        $this->CI->load->view( $template, $data );

        //加载Footer文件
        if ( !empty( $this->CI->data['footer'] ) ) {
            $this->CI->load->view( $this->CI->data['footer'], $data );
        }

    }

    /**
     * 创建模板目录以及模板文件
     */
    public function init_tpl_dir ( $template = '' )
    {

        //创建目录 以及 当前方法的文件
        $template = $template ? $template : $this->sitemethod;
        $template_file = $this->template_dir . $template . '.php';

        //创建目录
        if ( !file_exists( $template_file ) ) {
            creat_dir_with_filepath( $template_file );
        }

        //创建以当前方法为文件名的文件
        if ( !file_exists( $template_file ) ) {
            $handle = @fopen( $template_file, 'w' );
            @fwrite( $handle, '<?php' . "\r\n" );
            @fclose( $handle );
        }
    }


}