<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/11/20 19:03
 * FileName : Mini_programa.php
 */

class Mini_programa_lib extends ProgramaLib
{

    public function __construct ()
    {
        parent::__construct();
    }

    /**
     * 登录凭证校验。通过 wx.login() 接口获得临时登录凭证 code
     * 后传到开发者服务器调用此接口完成登录流程
     */
    public function Code2Session ()
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $this->appid . '&secret=' . $this->appsec . '&js_code=' . _get( 'code' ) . '&grant_type=authorization_code';
        $result = $this->curlHttPost( $url );

        return $result;
    }

}

