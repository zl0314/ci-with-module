<?php

/**
 * Created by Aaron Zhang.
 * Date: 2017/12/19 20:30
 * FileName : controllers.php
 */
class News extends Base_Controller
{

    public function __construct ()
    {
        //表名
        $this->tb = 'news';
        //主键
        $this->primary = 'id';
        //创建时间
        $this->hasCreated = true;
        //更新时间
        $this->hasUpdated = true;

        parent::__construct();
    }

    /**
     * 保存成功后， 保存关键字
     *
     * @param       $id
     * @param array $data
     *
     * @return mixed|void
     */
    public function saveCallback ( $id, $data = [] )
    {
        if ( !empty( $data['keyword'] ) ) {
            $this->model->saveKeyword( $id, $this->tb, $data['keyword'] );
        }
    }

    /**
     * 删除后， 也删除关键字
     *
     * @param $ids
     *
     * @return mixed|void
     */
    public function deleteCallback ( $ids )
    {
        $this->model->deleteKeyword( $ids, 'news' );
    }

}