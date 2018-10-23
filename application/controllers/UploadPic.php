<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

/**
 * [公共图片操作]
 * @date 2015-5-12
 **/
class UploadPic extends CI_Controller
{

    public function index ()
    {
        $type = _get( 'path', 'default' );
        $this->upload( $type );
    }

    /**
     * [上传]
     * @date 2015-5-12
     **/
    public function upload ( $upload = '' )
    {

        $this->config->load( 'upload' );
        $upload = $upload ? $upload : 'default';
        $config = $this->config->item( $upload );

        if ( empty( $config ) ) {
            $config = $this->config->item( 'default' );
        }
        //如果指定了上传路径($upload)，改变路径
        if ( $upload ) {
            $config['upload_path'] = './uploads/' . $upload . '/' . date( 'Y/m/d/' ). rand( 10000, 99999 ) . '/';
        }

        //如果用GET方式指定文件上传对象，$upload就是GET方式传递的文件上传对象
        $filedata = !empty( $_GET['filedata'] ) ? $_GET['filedata'] : $upload;
        if ( empty( $_FILES ) ) {
            exit( '文件对象为空' );
        }
        //创建上传目录

        creat_dir_with_filepath( $config['upload_path'] . $_FILES[ $filedata ]['name'] );
        $allow_size = str_replace( 'M', '', ini_get( 'upload_max_filesize' ) ) * 1024 * 1024;
        if ( $_FILES[ $filedata ]['size'] > $allow_size ) {
            exit( '图片大小不能超过' . ini_get( 'upload_max_filesize' ) );
        }


        $this->load->library( 'upload', $config );
        $error = '';
        if ( !$this->upload->do_upload( $filedata ) ) {
            $error = $this->upload->display_errors( '', '' );
        } else {
            $imgdata = $this->upload->data();
            $data['url'] = trim( $config['upload_path'], '.' ) . $imgdata['file_name'];
            $source_pic = './' . $data['url'];
            //图片裁剪处理
            if ( _post( 'width' ) && _post( 'height' ) && file_exists( $source_pic ) ) {
                $this->load->library( 'picthumb' );
                $thumb = PhpThumbFactory::create( $source_pic );
                $thumb->resize( _post( 'width' ), _post( 'height' ) );
                $thumb->save( $source_pic );
            }
        }

        //返回图片URL
        if ( !empty( $data['url'] ) ) {
            success(
                $arr = [
                    'state'  => 1,
                    'path'   => $data['url'],
                    'errmsg' => '上传成功',
                ]
            );
        } else {
            fail(
                $arr = [
                    'state'  => 0,
                    'path'   => '',
                    'errmsg' => $error,
                ]
            );
        }
        exit;

    }

    /**
     * [删除]
     * @date 2015-5-12
     **/
    public function delete ()
    {
        $pics = request_post( 'pic' ) ? request_post( 'pic' ) : request_get( 'pic' );
        $truepic = '';
        if ( $pics && is_array( $pics ) ) {
            foreach ( $pics as $k => $pic ) {
                $truepic = './' . $pic;
                if ( file_exists( $truepic ) ) {
                    @unlink( $truepic );
                    $newImg = getNewImg( $pic );
                    @unlink( '.' . $newImg );
                }
            }
        } else {
            $truepic = '.' . $pics;
            if ( file_exists( $truepic ) ) {
                @unlink( $truepic );
                $newImg = getNewImg( $pics );
                @unlink( $newImg );
            }
        }
        echo 'ok';
        exit;
    }
}