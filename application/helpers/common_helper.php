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
