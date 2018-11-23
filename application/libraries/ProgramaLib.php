<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/11/20 19:11
 * FileName : ProgramaLib.php
 */

class ProgramaLib
{

    /**
     * 全局CI对象
     * @var CI_Controller
     */
    public $CI;

    /**
     * @var APPID
     */
    public $appid;
    /**
     * @var APPSEC
     */
    public $appsec;

    /**
     * 存储TOKEN表
     * @var string
     */
    public $tokenTb = 'tokens';

    /**
     * 全局配置项
     * @var array
     */
    public $config = [];

    public function __construct ()
    {
        $this->CI = &get_instance();
        $this->config = $this->CI->config->config;
        $this->appid = $this->CI->wechat_mini_p_appid;
        $this->appsec = $this->CI->wechat_mini_p_appsec;
    }


    /**
     * 返回Json数据
     *
     * @param     $data  数据
     * @param int $code  CODE
     *
     * @return mixed
     */
    public function json ( $data, $code = 0 )
    {
        $returnData = is_object( $data ) ? (array) $data : ( is_array( $data ) ? $data : [] );
        $returnData['message'] = !empty( $data['errmsg'] ) ? $data['errmsg'] : '';

        if ( is_string( $data ) ) {
            $returnData['message'] = $data;
        }
        $returnData['code'] = $code ? $code : ( !empty( $data['errcode'] ) ? $data['errcode'] : 0 );

        if ( isAjax() ) {
            echo json_encode( $returnData );
        } else {
            exit( $data );
        }
        exit;
    }

    /**
     * 发送HTTP请求
     *
     * @param       $url
     * @param array $data
     *
     * @return mixed
     */
    public function curlHttPost ( $url, $data = [] )
    {
        $ch = curl_init( trim( $url ) );
        curl_setopt( $ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT'] );

        if ( !empty( $data ) ) {
            curl_setopt( $ch, CURLOPT_POST, true );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, ( $data ) );
        }

        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1 );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
        $result = curl_exec( $ch );

        curl_close( $ch );
        $output = json_decode( $result );
        if ( !empty( $output->errcode ) ) {
            if ( isAjax() ) {
                $this->json( $output->errmsg, $output->errcode );
            } else if ( !empty( $this->postObj ) ) {
                $this->responseTextMsg( $output->errmsg );
            } else {
                exit( $output->errcode . ' ' . $output->errmsg );
            }
        }

        return $output;
    }

}