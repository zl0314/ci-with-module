<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/11/16 17:00
 * FileName : Media.php
 */

class Media extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->library( 'WechatLib' );

    }


    public function deleteCustomerMenu (  )
    {
        $token = $this->wechatlib->getToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$token;
        $result = $this->wechatlib->curlHttPost($url);
        P($result);

    }
    public function userinfo ()
    {
        $this->load->library( 'Tools/GetWechatUserinfo', null, 'userobj' );
        $result = $this->userobj->getCgiUserInfo( 'oy8WduEeEMOkaV6I-dzLF222DtqY' );
        P( $result );
    }

    public function index ()
    {
        $this->load->library( 'Tools/WechatMedia', [], 'media' );
        $result = false;
        //上传图片
        //$result = $this->media->upload( SITE_ROOT . 'static/admin/images/img14.png', 'image' );
        $result = $this->media->getMaterialCount();

        //$result = getimagesize( 'http://mmbiz.qpic.cn/mmbiz_jpg/sicwjP9z9hS1PuyzYy4lEz56VaaaSK5Z77oCNV6VUWBKn7uicQHCQR314zphfMf7KZgonoZ5TOJiaAbK964aMK9uw/0' );

        /**
         * Tl4K-cmWmCB_DQe49FhPmSZ1vhIZhhvgi2Rfbh-z2Ww img14.png
         * Tl4K-cmWmCB_DQe49FhPmdqvhx5t5I-UBDOC2uR9Isk desktop/pic/第1张
         * Tl4K-cmWmCB_DQe49FhPmbiT_e0c7UsuO41JmaNnneY img13.png
         * Tl4K-cmWmCB_DQe49FhPmRIxpg5u4fpomUAJ5A5CxwY 3.mp4
         * Tl4K-cmWmCB_DQe49FhPmY5GflEzI72JvFb7cXroI1I  music.mp3
         */
        //$result = $this->media->getMaterialInfo( 'Tl4K-cmWmCB_DQe49FhPmY5GflEzI72JvFb7cXroI1I' );
        P( $result );
    }


}