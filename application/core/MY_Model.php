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

    /**
     * 保存关键字
     *
     * @param       $id
     * @param       $source_t 目标表
     * @param       $keyword  关键字
     *
     * @return mixed|void
     */
    public function saveKeyword ( $id, $source_t, $keyword )
    {
        if ( !empty( $id ) ) {
            $row = $this->CI->rs_model->getOne( 'keyword', 'id', [ 'target_id' => $id, 'source' => $source_t ] );
            if ( empty( $row ) ) {
                $this->CI->rs_model->save( 'keyword', [
                    'target_id'  => $id,
                    'keyword'    => $keyword,
                    'source'     => ucfirst( $source_t ),
                    'created_at' => date( 'Y-m-d H:i:s' ),
                ] );
            }
        }
    }

    /**
     * 删除关键字
     *
     * @param       $ids
     * @param       $source_t 目标表
     *
     * @return mixed|void
     */
    public function deleteKeyword ( $ids, $source_t )
    {
        if ( !empty( $ids ) ) {
            foreach ( $ids as $k => $r ) {
                $this->CI->rs_model->delete( 'keyword', [ 'target_id' => $r, 'source' => $source_t ] );
            }
        }
    }
}
