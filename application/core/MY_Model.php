<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/11/6 15:58
 * FileName : MY_Model.php
 */
class MY_Model extends CI_Model
{
    public $attributes = [];
    public $CI;
    public $tb;

    public function __construct ()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    /**
     * @param $name  属性
     * @param $args  参数
     */
    public function __call ( $name, $args = '' )
    {
    }

    /**
     * @param $name  属性
     * @param $value 值
     */
    public function __set ( $name, $value )
    {
        $this->$name = $value;
    }

    /**
     * @param string $name 属性
     *
     * @return mixed
     */
    public function __get ( $name )
    {
        return $this->$name;
    }
}
