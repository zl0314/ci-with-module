<?php
/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 21:21
 * FileName : common_helper.php
 */
/**
 * 创建多级文件夹 参数为带有文件名的路径
 *
 * @param string $path 路径名称
 */
function creat_dir_with_filepath ( $path, $mode = 0777 )
{
    return creat_dir( dirname( $path ), $mode );
}

/**
 * 创建多级文件夹
 *
 * @param string $path 路径名称
 */
function creat_dir ( $path, $mode = 0777 )
{
    if ( !is_dir( $path ) ) {
        if ( creat_dir( dirname( $path ) ) ) {
            return @mkdir( $path, $mode );
        }
    } else {
        return true;
    }
}


if ( !function_exists( 'redirect_manager' ) ) {
    /**
     * 后台跳转地址
     *
     * @param $url 跳转的地址
     */
    function redirect_manager ( $url )
    {
        $prefx = explode('/',$url)[0];
        //$prefx . '/' .
        return redirect( site_url(  MANAGER_PATH . '/' . $url ) );
    }

}

/**
 * 执行成功输出, 用ajax请求输出JSON数据
 *
 * @param array   $data
 * @param string  $message
 * @param boolean $is_app
 * @param int     $success
 */
function success ( $data = [], $message = '', $success = '1' )
{
    header( 'Content-type:text/json' );
    $result = [
        'success' => $success,
        'data'    => $data,
        'message' => $message,
    ];
    if ( !is_array( $data ) ) {
        $result['message'] = $data;
    }
    if ( is_array( $message ) ) {
        $result['data'] = $message;
        $result['message'] = !empty( $message['message'] ) ? $message['message'] : $message;
    }
    echo json_encode( $result );
    exit;
}

/**
 * 执行失败输出, 用ajax请求输出JSON数据
 *
 * @param array   $data
 * @param string  $message
 * @param boolean $is_app
 * @param int     $success
 */
function fail ( $message = '', $data = [] )
{
    success( $data, $message, '0' );
}

/**
 * 错误信息提示
 *
 * @param        $err  错误提示
 * @param string $url  要跳转到的URL
 * @param int    $sec  N秒后跳转到$url
 */
function showMessage ( $err, $url = '', $sec = 2 )
{
    if ( isAjax() ) {
        fail( $err );
    } else {
        $CI = &get_instance();
        $prefix = $CI->uri->segment( 1 );

        $data = [
            'sec' => $sec * 1000,
            'url' => reMoveXss( $url ),
            'err' => reMoveXss( $err ),
        ];

        if ( $prefix == MANAGER_PATH ) {
            $CI->load->view( MANAGER_PATH . '/message', $data );
        } else {
            if ( $CI->agent->is_mobile ) {
                mobileMessage( $err, 1 );
                exit;
            } else {
                $CI->load->view( 'message', $data );
            }
        }
    }

}

/*
 * 获取完整表名
 * @param string $tb
 */
function tname ( $tb )
{
    return DB_PREFIX . $tb;
}

/**
 * 打印数组，
 *
 * @param array $arr
 */
function P ( $arr )
{
    echo '<pre>';
    print_r( $arr );
    echo '</pre>';
}

/**
 * 打印数组，并退出
 *
 * @param array $arr
 */
function dd ( $var )
{
    P( $var );
    exit;
}

//过滤字符
function newhtmlspecialchars ( $string )
{
    if ( is_array( $string ) ) {
        return array_map( 'newhtmlspecialchars', $string );
    } else {
        $string = htmlspecialchars( $string );
        $string = sstripslashes( $string );
        $string = saddslashes( $string );

        return trim( $string );
    }
}

//去掉slassh
function sstripslashes ( $string )
{
    if ( is_array( $string ) ) {
        foreach ( $string as $key => $val ) {
            $string[ $key ] = sstripslashes( $val );
        }
    } else {
        $string = stripslashes( $string );
    }

    return $string;
}

function saddslashes ( $string )
{
    if ( is_array( $string ) ) {
        foreach ( $string as $key => $val ) {
            $string[ $key ] = saddslashes( $val );
        }
    } else {
        $string = addslashes( $string );
    }

    return $string;
}


/**
 * 得到$_POST下某值
 *
 * @param string $key
 * @param string $default 默认值
 * @param bool   $strict  是否严谨模式，在严谨模式下，会判断值是否为空
 *
 * @return array string  NULL
 * @author ZhangLong
 * @date   2015-05-12
 */
function _post ( $key = '', $default = '', $strict = false, $act = '_POST' )
{
    $method = $_POST;
    if ( $act == '_GET' ) {
        $method = $_GET;
    }
    if ( $key ) {
        if ( !$strict ) {
            if ( isset( $method[ $key ] ) ) {
                return newhtmlspecialchars( $method[ $key ] );
            } else {
                return $default;
            }
        } else {
            if ( !empty( $method[ $key ] ) ) {
                return newhtmlspecialchars( $method[ $key ] );
            } else {
                return $default;
            }
        }
    } else {
        return newhtmlspecialchars( $method );
    }
}

/**
 * 得到$_GET下某值
 *
 * @param string $key
 * @param string $default 默认值
 * @param bool   $strict  是否严谨模式，在严谨模式下，会判断值是否不为空
 *
 * @return array string  NULL
 * @author ZhangLong
 * @date   2015-05-12
 */
function _get ( $key = '', $default = '', $strict = false )
{
    return _post( $key, $default, $strict, '_GET' );
}

/**
 * 获取后台管理的URL
 *
 * @param $url URL
 *
 * @return string 后台 URL
 */
function manager_url ( $url, $param = '' )
{
    $prefx = explode('/',$url)[0];
    //$prefx . '/' .
    $url = site_url(  MANAGER_PATH . '/' . $url );
    $url = $param ? $url . '?' . $param : $url;

    return $url;
}

/**
 * 读取数据并分页
 *
 * @param array  $where   条件
 * @param null   $model   result_model
 * @param int    $perpage 每页显示 数量
 * @param string $sort    默认排序
 * @param string $field   字段
 *
 * @return array  返回结果
 */
function get_page ( $tb, $where = [], $perpage = 10, $field = '*', $order = '', $page_query = '' )
{
    $CI =& get_instance();
    $model = $CI->rs_model;
    $total_rows_row = $model->getRow( $tb, "Count(*) as cnt ", $where, $order );
    $page['total_rows'] = $total_rows_row['cnt'];
    // 加载分页类
    $CI->load->library( 'pagination' );
    $pagination = new CI_Pagination();


    // 当前 控制器
    $siteclass = SITEC;
    //  当前方法
    $sitemethod = SITEM;

    // 分页属性配置
    $current_page = intval( max( 1, $CI->input->get( 'per_page' ) ) );

    //每页数量
    $page['per_page'] = isset( $page['per_page'] ) ? $page['per_page'] : ( $perpage ? $perpage : 10 );
    if ( _get( 'export' ) ) {
        $page['per_page'] = $page['total_rows'];
    }
    $page['cur_page'] = ( $current_page < 1 ) ? 1 : $current_page;
    //页码
    $page['offset'] = ( $page['cur_page'] - 1 ) * $page['per_page'];

    //导出操作
    if ( _get( 'export' ) ) {
        $page['offset'] = null;
        $page['per_page'] = 0;
    }

    $page['first_link'] = ' 首页 ';
    $page['last_link'] = ' 末页 ';
    $page['next_link'] = ' &gt; ';
    $page['prev_link'] = ' &lt; ';
    $page['use_page_numbers'] = true;
    $page['page_query_string'] = true;

    $tag_open = '<li class="paginItem">';
    $tag_close = '</li>';

    $page['first_tag_open'] = $tag_open;
    $page['first_tag_close'] = $tag_close;

    $page['prev_tag_open'] = $tag_open;
    $page['prev_tag_close'] = $tag_close;

    $page['cur_tag_open'] = $tag_open . '<a href="javascript:;">';
    $page['cur_tag_close'] = '</a>' . $tag_close;

    $page['num_tag_open'] = $tag_open;
    $page['num_tag_close'] = $tag_close;

    $page['next_tag_open'] = $tag_open;
    $page['next_tag_close'] = $tag_close;

    $page['last_tag_open'] = $tag_open;
    $page['last_tag_close'] = $tag_close;

    $GLOBALS['total_rows'] = $page['total_rows'];
    $GLOBALS['curpage'] = $page['cur_page'];
    $GLOBALS['perpage'] = $page['per_page'];

    //查询数据
    $data = [];
    $data['total_rows'] = $page['total_rows'];
    if ( $model ) {
        $data['list'] = $model->getList( $tb, $field, $where, $page['per_page'], $page['offset'], $order );
        $page['base_url'] = '';
        $page['base_url'] .= $page_query ? $page['base_url'] . '/' . $page_query : $page['base_url'];
        $page['base_url'] .= sprintf( '?hash=1' );
        $page['base_url'] .= getQueryUrl();
        $pagination->initialize( $page );
        $data['page_html'] = $pagination->create_links();
    }

    return $data;
}

function getQueryUrl ()
{
    $url = '';
    if ( !empty( $_SERVER['QUERY_STRING'] ) ) {
        $strA = explode( '&', $_SERVER['QUERY_STRING'] );
        $con = '&';
        $strA = array_unique( $strA );
        foreach ( $strA as $k => $r ) {
            $rA = explode( '=', $r );
            if ( $rA[0] != 'per_page' ) {
                $url .= $con . $rA[0] . '=' . $rA[1];
            }
        }
    }

    return $url;
}

//是否是ajax请求
function isAjax ()
{
    if ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
        return true;
    }

    return false;
}


function arraySort ( $arr, $keys, $type = 'desc' )
{
    $keysvalue = $new_array = [];
    foreach ( $arr as $k => $v ) {
        $keysvalue[ $k ] = $v[ $keys ];
    }
    if ( $type == 'asc' ) {
        asort( $keysvalue );
    } else {
        arsort( $keysvalue );
    }
    reset( $keysvalue );
    $i = 0;
    foreach ( $keysvalue as $k => $v ) {
        $new_array[ $i ] = $arr[ $k ];
        $i++;
    }

    return $new_array;
}


/**
 * +----------------------------------------------------------
 * 字符串命名风格转换
 * type
 * =0 将Java风格转换为C的风格
 * =1 将C风格转换为Java的风格
 * +----------------------------------------------------------
 * @access protected
 * +----------------------------------------------------------
 *
 * @param string  $name 字符串
 * @param integer $type 转换类型
 *                      +----------------------------------------------------------
 *
 * @return string
+----------------------------------------------------------
 */
function ParseVarName ( $name, $type = 0 )
{
    if ( $type ) {
        return ucfirst( preg_replace( "/_([a-zA-Z])/e", "strtoupper('\\1')", $name ) );
    } else {
        $name = preg_replace( "/[A-Z]/", "_\\0", $name );

        return strtolower( trim( $name, "_" ) );
    }
}

//判断是否为邮箱格式
function isEmail ( $email )
{
    return strlen( $email ) > 8 && preg_match( "/^[-_+.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+([a-z]{2,4})|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email );
}

function isUserName ( $string )
{
    //只允许汉字，大小写字母，数字作为用户名
    return preg_match( "/^[\x{4e00}-\x{9fa5}|a-z|A-Z|0-9]+$/u", $string );
}

//是否是正确的URL
function isUrl ( $url )
{
    return preg_match( '/http:\/\/([a-zA-Z0-9-]*\.)+[a-zA-Z]{2,3}/', $url );
}

//是否是中文格式的姓名
function isCnName ( $string )
{
    //只允许汉字，大小写字母，数字作为用户名
    return preg_match( "/^[\x{4e00}-\x{9fa5}]+$/u", $string );
}

/**
 * @desc 检查是否是合法的手机号格式，现阶段合法的格式：以13,15,18,17,14,19开头的11位数字
 *
 * @param $cellphone
 */
function isTelphone ( $cellphone )
{
    $pattern = "/^(13|15|18|17|14|16|19){1}\d{9}$/";

    return strMatch( $pattern, $cellphone );
}

//检查是否是合法的固定电话
function isCellphone ( $telphone )
{
    $pattern = "/^(0){1}[0-9]{2,3}\-\d{7,8}(\-\d{1,6})?$/";

    return strMatch( $pattern, $telphone );
}

//是否身份证号
function isIdcard ( $idcard )
{
    $cardnumPattern = '/^\d{6}((1[89])|(2\d))\d{2}((0\d)|(1[0-2]))((3[01])|([0-2]\d))\d{3}(\d|X)$/i';
    $match = preg_match( $cardnumPattern, $idcard );

    return $match;
}

//字符串匹配
function strMatch ( $pattern, $str )
{
    if ( !empty( $str ) ) {
        if ( preg_match( $pattern, $str ) ) {
            return true;
        }
    }

    return false;
}

//如果URL没有HTTP， 添加HTTP， 如果URL为空，则链接为javascript:;
function getAddHttpUrl ( $url, $id = '' )
{
    if ( $url ) {
        if ( strpos( $url, 'http' ) !== false ) {
            return $url;
        } else {
            return 'http://' . $url;
        }
    } else {
        return 'javascript:;';
    }
}


/**
 * 隐藏手机号中间部分
 *
 * @param $tel 手机号
 *
 * @return string
 */
function formatTel ( $tel )
{
    if ( $tel ) {
        $telpre = substr( $tel, 0, 3 );
        $telsuffix = substr( $tel, strlen( $tel ) - 4 );
        $tel = $telpre . str_repeat( '*', strlen( $tel ) - 7 ) . $telsuffix;

        return $tel;
    }
}


/**
 * 隐藏身份证中间部分
 *
 * @param $idcard 身份证号
 *
 * @return string
 */
function formatIdcard ( $idcard )
{
    if ( $idcard ) {
        $pre = substr( $idcard, 0, 3 );
        $suffix = substr( $idcard, strlen( $idcard ) - 4 );
        $idcard = $pre . str_repeat( '*', strlen( $idcard ) - 7 ) . $suffix;

        return $idcard;
    }

    return '';
}

/**
 * Lang
 * Fetches a language variable and optionally outputs a form label
 *
 * @param    string $line       The language line
 * @param    string $for        The "for" value (id of the form element)
 * @param    array  $attributes Any additional HTML attributes
 *
 * @return    string
 */
function lang ( $line, $data = [] )
{
    $value = $line;
    $line = get_instance()->lang->line( $line );
    if ( !empty( $data ) ) {

        foreach ( $data as $k => $r ) {
            $line = str_replace( '{' . $k . '}', $r, $line );
        }
    }

    return $line ? $line : $value;
}