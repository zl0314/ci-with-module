<?php
/**
 * 素材管理
 * Created by Aaron Zhang.
 * Date: 2018/11/16 15:37
 * FileName : Media.php
 */

class WechatMedia extends WechatLib
{
    public function __construct ()
    {
        parent::__construct();
    }


    /**
     * 多媒体上传。上传图片、语音、视频等文件到微信服务器，上传后服务器会返回对应的media_id，公众号此后可根据该media_id来获取多媒体。
     * 上传的多媒体文件有格式和大小限制，如下：
     * 图片（image）: 1M，支持JPG格式
     * 语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
     * 视频（video）：10MB，支持MP4格式
     * 缩略图（thumb）：64KB，支持JPG格式
     * 媒体文件在后台保存时间为3天，即3天后media_id失效。
     *
     * @param $filename，文件绝对路径
     * @param $type , 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     *
     * @return {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
     */
    public function upload ( $filename, $type, $data = [] )
    {
        $accessToken = $this->getToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=' . $accessToken . '&type=' . $type;
        $data['media'] = $this->addFile( $filename );

        return $this->curlHttPost( $queryUrl, $data );
    }

    /**
     * type     素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
     * offset   从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
     * count   返回素材的数量，取值在1到20之间
     * @return mixed
     */
    public function getMediaList ( $type, $offset, $count )
    {
        $accessToken = $this->getToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=' . $accessToken;
        $template = [
            'type'   => $type,
            'offset' => $offset,
            'count'  => $count,
        ];
        $template = json_encode( $template, JSON_UNESCAPED_UNICODE );

        return $this->curlHttPost( $queryUrl, $template );
    }

    /**
     * 获取素材的总数
     * @return { "voice_count":COUNT,"video_count":COUNT,"image_count":COUNT,"news_count":COUNT}
     */
    public function getMaterialCount ()
    {
        $accessToken = $this->getToken();
        $queryUrl = 'https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=' . $accessToken;

        return $this->curlHttPost( $queryUrl );
    }

    public function getMaterialInfo ( $media_id )
    {
        $token = $this->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=' . $token;
        $template = [
            'media_id' => $media_id,
        ];
        $template = json_encode( $template, JSON_UNESCAPED_UNICODE );

        return $this->curlHttPost( $url, $template );
    }

    /**
     * 上传文件
     *
     * @param $filename 文件名+路径
     *
     * @return \CURLFile|string 返回可直接用于Curl发送的模式
     * PHP5.5以后，将废弃以@文件名的方式上传文件。
     */
    public function addFile ( $filename )
    {
        return class_exists( '\CURLFile' ) ? new \CURLFile( $filename ) : '@' . $filename;
    }
}