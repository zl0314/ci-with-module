<?php

/**
 * RSA加密解密算法
 * Created by PhpStorm.
 * User: zhang
 * Date: 2017/10/30
 * Time: 14:54
 *
 */
class Rsa
{
    public function __construct()
    {
    }

    /**
     * @param $data  要加密的字符串
     * @param $private_key  公钥
     * @return mixed 加密的结果
     */
    public function publicDecrypt($data, $public_key)
    {
        $public_key = file_get_contents($public_key);
        $pub_key = openssl_pkey_get_public($public_key);
        openssl_public_encrypt($data, $encrypted, $pub_key);
        $encrypted = base64_encode($encrypted);//因为加密后是乱码,所以base64一下
        return $encrypted;
    }

    /**
     * @param $data  要解密的字符串
     * @param $private_key  私钥
     * @return mixed 解密的结果
     */
    public function privateDecrypt($data, $private_key)
    {
        $encrypted = base64_decode($data);
        $private_key = file_get_contents($private_key);
        $pi_key = openssl_pkey_get_private($private_key);
        openssl_private_decrypt($encrypted, $decrypted, $pi_key);
        return $decrypted;
    }
}