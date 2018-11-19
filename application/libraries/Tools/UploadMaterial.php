<?php
/**
 * 互动上传素材功能
 * Created by Aaron Zhang.
 * Date: 2018/11/16 19:00
 * FileName : UploadMaterial.php
 */

class UploadMaterial extends Response
{
    public function __construct ()
    {
        parent::__construct();
    }

    public function startProcess ()
    {
        if ( $this->postObj->Content == '退出' ) {
            $this->cleanData();
            $this->responseTextMsg( '成功退出本次互动' );
        }

        //到第几步了
        $step = $this->CI->cache->redis->get( $this->cacheKey . '_step' );
        //缓存存储的数据
        $data = $this->CI->cache->redis->get( $this->cacheKey . '_data' );

        if ( !empty( $step ) ) { // 第二步
            if ( $step == 2 ) {
                if ( $this->postObj->Content == '确认' ) { //确认标题后，上传素材
                    $this->CI->cache->redis->save( $this->cacheKey . '_step', '3', 7200 ); //第三步， 上传素材
                    $msg = '请上传素材' . "\r\n";
                    $msg .= '图片（限1张） 1M以内' . "\r\n";
                    $msg .= '语音（限1张） 2M以内，mp3/wma/wav/amr格式不超过60秒' . "\r\n";
                    $msg .= 'mp4（限1张） 10MB以内)。' . "\r\n";
                    $msg .= '回复【退出】结束本次互动';
                    $this->responseTextMsg( $msg );
                } else {
                    $data['title'] = (string) trim( $this->postObj->Content );
                    $this->CI->cache->redis->save( $this->cacheKey . '_data', $data, 7200 ); //设置标题
                    $this->responseTextMsg( '标题为：【' . $this->postObj->Content . '】，确定吗？不做修改， 请回复【确认】' );
                }
            } else if ( $step == 3 && in_array( $this->postObj->MsgType, [ 'image', 'voice', 'video' ] ) ) { //第三步， 上传素材
                if ( $this->postObj->MsgType == 'image' ) {
                    $picUrl = $this->postObj->PicUrl;
                    //$ext = '.jpg';
                    //获取图片类型
                    //$imgInfo = getimagesize( $picUrl );
                    //if ( $imgInfo['mime'] == 'image/png' ) {
                    //    $ext = '.png';
                    //}
                    //$uploadPath = './uploads/material/' . date( 'Y/m/d/' ) . rand( 10000, 99999 ) . '/' . md5( $picUrl ) . $ext;
                    //$picContent = file_get_contents( $this->postObj->PicUrl );
                    //creat_dir_with_filepath( $uploadPath );
                    //file_put_contents( $uploadPath, $picContent );
                    //$data['media_url'] = ltrim( $uploadPath, '.' );
                    $data['media_url_remote'] = $picUrl;

                    //$this->CI->load->library( 'Tools/WechatMedia' );
                    //上传图片
                    //$result = $this->CI->wechatmedia->upload( SITE_ROOT . $data['media_url'], 'image' );
                    $data['media_id'] = (string) $this->postObj->MediaId;
                    $data['type'] = 'image';
                } else if ( $this->postObj->MsgType == 'voice' ) {
                    $data['media_id'] = (string) $this->postObj->MediaId;
                    $data['type'] = 'voice';
                } else if ( $this->postObj->MsgType == 'video' ) {
                    $data['media_id'] = (string) $this->postObj->MediaId;
                    $data['type'] = 'video';
                    $data['thumb_media_id'] = (string) $this->postObj->ThumbMediaId;
                }

                $this->CI->cache->redis->save( $this->cacheKey . '_data', $data, 7200 ); //设置图片信息
                $this->CI->cache->redis->save( $this->cacheKey . '_step', 4, 7200 ); //设置图片信息

                $this->responseTextMsg( '素材上传成功， 请回复触发关键字。' );
            } else if ( $step == 4 ) {
                if ( trim( $this->postObj->Content ) == '确认' ) {
                    $data['created_at'] = date( 'Y-m-d H:i:s' );
                    $saveResult = $this->CI->rs_model->save( 'material', $data );
                    if ( $saveResult ) {
                        $this->CI->rs_model->saveKeyword( $saveResult, 'material', $data['keyword'] );
                        $this->cleanData();
                        $this->responseTextMsg( '恭喜您， 素材上传成功。回复【' . $data['keyword'] . '】查看效果' );
                    } else {
                        $this->responseTextMsg( '上传素材失败' );
                    }
                } else {
                    $data['keyword'] = (string) trim( $this->postObj->Content );
                    $this->CI->cache->redis->save( $this->cacheKey . '_data', $data, 7200 ); //设置标题
                    $this->responseTextMsg( '关键字为：【' . $this->postObj->Content . '】，确定吗？不做修改， 请回复【确认】' );
                }
            }
        }

        Mylog::error( '上传素材== set before' );
        $defaultData = [ 'openid' => (string) $this->postObj->FromUserName ];
        $this->CI->cache->redis->save( $this->cacheKey . '_data', $defaultData, 7200 );
        $this->CI->cache->redis->save( $this->cacheKey . '_step', '2', 7200 );
        Mylog::error( '上传素材== set after' );

        //输出提示消息
        $this->responseTextMsg( '请回复素材标题。回复【退出】结束本次互动' );
    }

    /**
     * 清空记录数据
     */
    protected function cleanData ()
    {
        $this->CI->cache->redis->delete( $this->cacheKey . '_action' );
        $this->CI->cache->redis->delete( $this->cacheKey . '_step' );
        $this->CI->cache->redis->delete( $this->cacheKey . '_data' );
    }
}