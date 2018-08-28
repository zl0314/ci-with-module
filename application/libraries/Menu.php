<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/8/24 15:08
 * FileName : menu.php
 */
class Menu extends BaseLib
{
    /**
     *  获取所有权限菜单， 用在添加菜单的时候， 级别选择,让所有的菜单有一个上下级别
     * @return mixed
     */
    public function treePermisstionsByLevel ()
    {
        $lists = $this->getALLMenus();

        $treeList = [];
        foreach ( $lists as $k => $r ) {
            if ( $r['parent_id'] != 0 ) {
                continue;
            }
            $r['level'] = 0;
            $treeList[ $r['id'] ] = $r;
            unset( $r[ $k ] );
            $temp = self::getSubmenusByLevel( $r['id'], $lists, 1 );
            if ( is_array( $temp ) ) {
                foreach ( $temp as $v ) {
                    if ( !is_array( $v ) ) {
                        continue;
                    }
                    $treeList[ $v['id'] ] = $v;
                }
            }
        }

        return $treeList;
    }

    /**
     * 得到一级菜单的子菜单
     *
     * @param $id    父级ID
     * @param $lists 所有权限菜单
     * @param $level 默认级别
     *
     * @return array
     */
    protected function getSubmenusByLevel ( $cur_id, $lists, $level = 0 )
    {
        $return = [];
        foreach ( $lists as $k => $r ) {
            if ( $r['parent_id'] != $cur_id ) {
                continue;
            }
            $r['level'] = $level;
            $return[] = $r;
            unset( $lists[ $k ] );
            $subMenu = self::getSubmenusByLevel( $r['id'], $lists, $level + 1 );
            if ( is_array( $subMenu ) ) {
                foreach ( $subMenu as $val ) {
                    if ( !is_array( $val ) ) {
                        continue;
                    }
                    $return[] = $val;
                }
            }
        }

        return $return;
    }

    /**
     * 得到所有的权限菜单
     * @return mixed
     */
    protected function getALLMenus ()
    {
        $admin_info = $this->admin_info;
        //查询管理员所在的角色， 获取所拥有角色的所有权限
        $admin = $this->CI->rs_model->getRow( 'adminuser', '*', [ 'id' => $admin_info['id'] ] );

        if ( !$admin['is_super'] ) { //不是超级管理员，获取角色所拥有的权限节点

            //获取所有所属的角色
            $roles = $this->CI->rs_model->getList( 'admin_user_role', '*', [ 'admin_user_id' => $admin_info['id'] ] );
            $permissions = [];
            if ( !empty( $roles ) ) {
                //获取所有角色的所有权限
                $perviligesRole = $this->CI->rs_model->getList( 'privileges_role', '*',
                    [
                        'in' => [
                            'role_id' => array_column( $roles, 'role_id' ),
                        ],
                    ] );
                if ( !empty( $perviligesRole ) ) {
                    foreach ( $perviligesRole as $r ) {
                        $permissions[] = $this->CI->rs_model->getRow( 'privileges', '*', [ 'id' => $r['privileges_id'] ] );
                    }
                }
            }

            return $permissions;
        } else {
            //超管返回所有权限节点
            $lists = $this->CI->rs_model->getList( 'privileges', '*', [], null, null, 'listorder desc' );

            return $lists;
        }
    }

    /**
     * 根据显示位置，获取菜单
     */
    public function getMenuByShowAt ( $where )
    {
        $lists = $this->CI->rs_model->getList( 'privileges', '*', $where, null, null, 'listorder desc' );

        return $lists;
    }

    /**
     * 当前位置
     *
     * @param $siteclass
     * @param $sitemethod
     */
    public function getPosition ( $siteclass, $sitemethod )
    {
        $menu = $this->CI->rs_model->getRow( 'privileges', 'name', [ 'controller' => $siteclass ] );

        return $menu['name'];
    }
}