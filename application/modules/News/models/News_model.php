<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/11/1 17:51
 * FileName : News_model.php
 */
class News_model extends MY_Model
{
    public function __construct ()
    {
        parent::__construct();
    }

    /**
     * 获取模型内容， 把内容进行过滤处理
     * @return string 处理后的内容
     */
    public function getContentAttribute ()
    {
        if ( isset( $this->attributes['content'] ) ) {
            return htmlspecialchars_decode( $this->attributes['content'] );
        }
    }
}