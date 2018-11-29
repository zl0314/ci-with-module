<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Mini_programa extends MY_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->driver( 'cache', [ 'adapter' => 'redis', 'backup' => 'file' ] );
    }

    public function index ()
    {
    }

    public function login ()
    {
        if ( !empty( _get( 'code' ) ) ) {
            $result = $this->lib->Code2Session();
            $authKey = md5( $result->session_key . $result->openid );
            $data = [
                'auth_key'    => $authKey,
                'openid'      => $result->openid,
                'session_key' => $result->session_key,
            ];
            $this->cache->redis->save( $authKey, $data, 86400 * 7 );
            success( [ 'session_key' => $authKey, 'openid' => $result->openid, 'sess_id' => session_id() ] );
        }else{
            fail('参数错误');
        }
    }

    public function checkLogin ()
    {
        $key = _get( 'session_key' );

        if ( !empty( $key ) ) {
            $info = $this->cache->redis->get( $key );
            if ( !empty( $info ) ) {
                success( [ 'session_key' => $info['auth_key'], 'openid' => $info['openid'], 'sess_id' => session_id() ] );
                $this->cache->redis->save( $key, $info, 86400 * 7 );
            } else {
                fail( '登录超时' );
            }
        } else {
            fail( '登录过期' );
        }
    }
}

