<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Privileges extends Base_Controller
{
    public function __construct ()
    {
        parent::__construct();
        $this->tb = 'privileges';
        $this->listorder = 'listorder desc';
        $this->needListOrder = true;

    }

    public function getData ()
    {
        $data = _post( 'data' );
        if ( empty( $data['controller'] ) ) {
            $data['controller'] = '#' . time();
        }
        $returnData['data'] = $data;
        unset( $returnData['data']['init_curd'] );

        return $returnData;
    }

    public function saveCallback ( $result )
    {
        $data = _post( 'data' );
        if ( !empty( $data['init_curd'] ) ) {
            $curd = [
                'create'       => '添加',
                'edit'         => '编辑',
                'delete'       => '删除',
                'batch_delete' => '批量删除',
            ];
            $saveData = [];
            foreach ( $curd as $k => $r ) {
                $show_at = 3;
                if ( $k == 'create' || $k == 'batch_delete' ) {
                    $show_at = 2;
                }
                $saveData[] = [
                    'controller' => $data['controller'],
                    'method'     => $k,
                    'name'       => $r,
                    'is_show'    => 1,
                    'show_at'    => $show_at,
                    'parent_id'  => $result,
                    'addtime'    => date( 'Y-m-d H:i:s' ),
                    'listorder'  => 0,
                ];
            }
            if ( !empty( $saveData ) ) {
                $this->rs_model->insert_batch( $this->tb, $saveData );
            }
        }
    }

    public function getWhere ()
    {
        $where = [
            'parent_id' => 0,
        ];

        return $where;
    }
}