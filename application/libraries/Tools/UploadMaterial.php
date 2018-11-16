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
            $this->CI->cache->redis->delete( $this->cacheKey . '_action' );
            $this->responseTextMsg( '成功退出本次互动' );
        }

        //到第几步了
        $step = $this->CI->cache->redis->get( $this->cacheKey . '_step' );
        //缓存存储的数据
        $data = $this->CI->cache->redis->get( $this->cacheKey . '_data' );

        if ( !empty( $step ) && $step == 2 ) { // 第二步

            if ( $this->postObj->Content == '确认' ) {
                $this->CI->cache->redis->save( $this->cacheKey . '_step', '3' ); //第三步， 上传素材
                $msg = '请上传素材' . "\r\n";
                $msg .= '图片 1M以内' . "\r\n";
                $msg .= '语音 2M以内， 不超过60秒' . "\r\n";
                $msg .= 'mp4 10MB以内)。' . "\r\n";
                $msg .= '回复【退出】结束本次互动';
                $this->responseTextMsg( $msg );
            } else {
                $data['title'] = (string) $this->postObj->Content;
                $this->CI->cache->redis->save( $this->cacheKey . '_data', $data ); //设置标题
                $this->responseTextMsg( '标题为：' . $this->postObj->Content . '，确定吗？不做修改， 请回复【确认】' );
            }
        }

        Mylog::error( '上传素材== set before' );
        $defaultData = [ 'openid' => (string) $this->postObj->FromUserName ];
        $this->CI->cache->redis->save( $this->cacheKey . '_data', $defaultData );
        $this->CI->cache->redis->save( $this->cacheKey . '_step', '2' );
        Mylog::error( '上传素材== set after' );

        //输出提示消息
        $this->responseTextMsg( '请回复素材标题。回复【退出】结束本次互动' );
    }
}