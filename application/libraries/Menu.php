<?php

/**
 * Created by Aaron Zhang.
 * Date: 2018/8/24 15:08
 * FileName : menu.php
 */
class Menu extends BaseLib
{
    public $admin_info;

    public function __construct ()
    {
        parent::__construct();
        $this->admin_info = $this->CI->session->userdata( 'admin_info' );
    }

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
     * 获取所有权限菜单， 分上下级， 只要有下级菜单，就会有submenu属性， 用在后台导航栏循环
     * @return mixed
     */
    public function treePermisstionsBySubMenus ()
    {
        $lists = self::getALLMenus();
        $treeList = [];
        foreach ( $lists as $k => $r ) {
            if ( $r['parent_id'] != 0 ) {
                continue;
            }
            $r['level'] = 0;
            $treeList[ $r['id'] ] = $r;
            unset( $r[ $k ] );
            $temp = self::getSubmenusBySubMenus( $r['id'], $lists, $treeList[ $r['id'] ] );
            if ( is_array( $temp ) && !empty( $temp ) ) {
                $treeList[ $r['id'] ]['parent'] = $treeList[ $r['id'] ];
                $treeList[ $r['id'] ]['submenu'] = $temp;
            }
        }

        return $treeList;
    }

    /**
     * 获取一级菜单下所有子菜单
     *
     * @param $cur_id 当前栏目ID
     * @param $lists  所有菜单
     *
     * @return array
     */
    public static function getSubmenusBySubMenus ( $cur_id, $lists, $parent, $sparent = null )
    {
        $temp = [];
        foreach ( $lists as $k => $r ) {
            if ( $r['parent_id'] == $cur_id ) {
                $temp[ $k ] = $r;
                $temp[ $k ]['parent'] = $parent;
                $temp[ $k ]['second_parent'] = $r['parent_id'];
                unset( $lists[ $k ] );
                $temp[ $k ]['submenu'] = self::getSubmenusBySubMenus( $r['id'], $lists, $parent );
            }
        }

        return $temp;
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
                        $permissions[] = $this->CI->rs_model->getRow( 'privileges', '*', [ 'id' => $r['permission_id'] ] );
                    }
                }
            }

            return arraySort( $permissions, 'listorder', 'desc' );
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
        $menu = $this->CI->rs_model->getRow( 'privileges', 'name', [ 'controller' => $siteclass, 'method' => 'index' ] );

        return $menu['name'];
    }


    /**
     * 当前控制器菜单信息
     *
     * @param $siteclass
     */
    public function getMenuInfo ( $siteclass, $sitemethod = 'index' )
    {
        $menu = $this->CI->rs_model->getRow( 'privileges', '*', [ 'controller' => $siteclass, 'method' => $sitemethod ] );

        return $menu;
    }

    /**
     * 获取所有子菜单
     *
     * @param $parent_id  父级ID
     *
     * @return mixed
     */
    public function getSubmenusByParentId ( $parent_id )
    {
        $menus = $this->CI->rs_model->getList( 'privileges', '*', [ 'parent_id' => $parent_id, ] );

        return $menus;
    }

    public function getMenuKeyBySiteclass ()
    {
        $menu = $this->getALLMenus();
        $menuBySiteclass = [];
        foreach ( $menu as $k => $r ) {
            $menuBySiteclass[ $r['controller'] ][ $r['method'] ] = $r;
        }

        return $menuBySiteclass;
    }
}