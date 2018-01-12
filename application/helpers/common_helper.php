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
function creat_dir_with_filepath($path, $mode = 0777)
{
    return creat_dir(dirname($path), $mode);
}

/**
 * 创建多级文件夹
 *
 * @param string $path 路径名称
 */
function creat_dir($path, $mode = 0777)
{
    if (!is_dir($path)) {
        if (creat_dir(dirname($path))) {
            return @mkdir($path, $mode);
        }
    } else {
        return true;
    }
}


if (!function_exists('redirect_manager')) {
    /**
     * 后台跳转地址
     * @param $url 跳转的地址
     */
    function redirect_manager($url)
    {
        return redirect(site_url(MANAGER_PATH . '/' . $url));
    }

}

if (!function_exists('manager_url')) {
    /**
     * 后台跳转地址
     * @param $url 跳转的地址
     */
    function manager_url($url)
    {
        return site_url(MANAGER_PATH . '/' . $url);
    }

}
/**
 * 执行成功输出, 用ajax请求输出JSON数据
 * @param array $data
 * @param string $message
 * @param boolean $is_app
 * @param int $success
 */
function success($data = array(), $message = '', $success = '1')
{
    $result = array(
        'success' => $success,
        'data' => $data,
        'message' => $message,
    );
    if (!is_array($data)) {
        $result['message'] = $data;
    }
    if (is_array($message)) {
        $result['data'] = $message;
        $result['message'] = !empty($message['message']) ? $message['message'] : $message;
    }
    echo json_encode($result);
    exit;
}

/**
 * 执行失败输出, 用ajax请求输出JSON数据
 * @param array $data
 * @param string $message
 * @param boolean $is_app
 * @param int $success
 */
function fail($message = '', $data = array())
{
    success($data, $message, '0');
}

/**
 * 错误信息提示
 * @param $err  错误提示
 * @param string $url 要跳转到的URL
 * @param int $sec N秒后跳转到$url
 */
function showMessage($err, $url = '', $sec = 2)
{
    if (isAjax()) {
        fail($err);
    } else {
        $CI = &get_instance();
        $prefix = $CI->uri->segment(1);

        $data = array(
            'sec' => $sec * 1000,
            'url' => reMoveXss($url),
            'err' => reMoveXss($err)
        );

        if ($prefix == MANAGER_PATH) {
            $CI->load->view(MANAGER_PATH . '/message', $data);
        } else {
            if ($CI->agent->is_mobile) {
                mobileMessage($err, 1);
                exit;
            } else {
                $CI->load->view('message', $data);
            }
        }
    }

}

/*
 * 获取完整表名
 * @param string $tb
 */
function tname($tb)
{
    return DB_PREFIX . $tb;
}

/**
 * 打印数组，
 * @param array $arr
 */
function P($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

/**
 * 打印数组，并退出
 * @param array $arr
 */
function dd($var)
{
    var_dump($var);
    exit;
}

//过滤字符
function newhtmlspecialchars($string)
{
    if (is_array($string)) {
        return array_map('newhtmlspecialchars', $string);
    } else {
        $string = htmlspecialchars($string);
        $string = sstripslashes($string);
        $string = saddslashes($string);
        return trim($string);
    }
}

//去掉slassh
function sstripslashes($string)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = sstripslashes($val);
        }
    } else {
        $string = stripslashes($string);
    }
    return $string;
}

function saddslashes($string)
{
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = saddslashes($val);
        }
    } else {
        $string = addslashes($string);
    }
    return $string;
}


/**
 * 得到$_POST下某值
 * @param string $key
 * @param string $default 默认值
 * @param bool $strict 是否严谨模式，在严谨模式下，会判断值是否为空
 * @return array string  NULL
 * @author ZhangLong
 * @date 2015-05-12
 */
function _post($key = '', $default = '', $strict = false, $act = '_POST')
{
    $method = $_POST;
    if ($act == '_GET') {
        $method = $_GET;
    }
    if ($key) {
        if (!$strict) {
            if (isset($method[$key])) {
                return newhtmlspecialchars($method[$key]);
            } else {
                return $default;
            }
        } else {
            if (!empty($method[$key])) {
                return newhtmlspecialchars($method[$key]);
            } else {
                return $default;
            }
        }
    } else {
        return newhtmlspecialchars($method);
    }
}

/**
 * 得到$_GET下某值
 * @param string $key
 * @param string $default 默认值
 * @param bool $strict 是否严谨模式，在严谨模式下，会判断值是否不为空
 * @return array string  NULL
 * @author ZhangLong
 * @date 2015-05-12
 */
function _get($key = '', $default = '', $strict = false)
{
    return _post($key, $default, $strict, '_GET');
}

/**
 * 获取后台管理的URL
 * @param $url URL
 * @return string 后台 URL
 */
function manager_url($url)
{
    return site_url(MANAGER_PATH . '/' . $url);
}