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

    public function public_get_submenus ()
    {
        $id = _post( 'id' );
        $id = intval( $id );
        $level = _post( 'level' ) ? _post( 'level' ) + 1 : 1;

        $subMenus = $this->menu->getSubmenusByParentId( $id );

        $html = '';
        if ( !empty( $subMenus ) ) {
            foreach ( $subMenus as $k => $r ) {

                $hasSubMenus = $r['parent_id'] == 0 ? '<span class="fa fa-chevron-right" style="cursor: pointer;" title="查看子菜单"
                                  onclick="getSubmenus(\'' . $r['id'] . '\')">&nbsp;</span>' : '';

                $html .= '<tr class="submenu_' . $id . '" id="item_' . $r['id'] . '" loaded="0" level="' . $level . '">';
                $html .= '<td><input type="checkbox" name="id[]" value="' . $r['id'] . '"></td>';
                $html .= '<td>' . $hasSubMenus . '</td>';
                $html .= '<td>' . str_repeat( '&nbsp;&nbsp;', $level * 2 ) . '|--&nbsp;' . $r['name'] . '</td>';
                $html .= '<td>' . $r['addtime'] . '</td>';
                $html .= '<td><input type="text" name="listorder['.$r['id'].']" id="" class="listorder" value="'.intval($r['listorder']).'"></td>';
                $html .= '<td>
                                <a class="tablelink"
                                   href="' . manager_url( $this->siteclass . '/edit?id=' . $r['id'] ) . '"><span > 编辑</span></a> | 
                                <a class="tablelink" href="javascript:;"
                                   onclick="del(\'' . $r['id'] . '\')"><span > 删除</span> </a>
                        </td>';
                $html .= '</tr>';
            }
        }

        echo $html;
    }
}