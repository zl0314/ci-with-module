<?php
header('Content-type: image/jpg');
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->helper('captcha');
        $config = array(
//             'word'      => 'Random word',
             'img_path'  => dirname(BASEPATH).'/public/cap',
            // 'img_url'   => '/static/captcha/',
            'img_width' => 60,
            'img_height' => 33,
            'word_length' => 4,
            'font_size' => 13,
            'pool' => '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

            // White background and border, black text and red grid
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
            ),
        );
        $cap = create_captcha($config, './cap');
        $this->session->set_userdata('captcha', $cap['word']);

    }
}