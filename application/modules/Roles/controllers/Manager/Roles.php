<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Roles extends Base_Controller
{
    public function __construct ()
    {
        $this->hasUpdated = true;
        $this->hasCreated = true;
        parent::__construct();
        $this->tb = 'roles';
        $this->listorder = 'id desc';
    }

    public function power ()
    {
        if ( _post() ) {
            return $this->save_power();
        } else {
            $role_id = intval( _get( 'id' ) );
            $role = $this->rs_model->getRow( $this->tb, '*', [ 'id' => $role_id ] );
            if ( empty( $role ) ) {
                $this->message( '角色信息不存在 ' );
            }
            //所有菜单项
            $menus = $this->menu->treePermisstionsBySubMenus();
            //角色所拥有的权限
            $roles_privileges = $this->rs_model->getList( 'privileges_role', '*', [ 'role_id' => $role_id ] );
            $roles_privileges = array_column( $roles_privileges, 'permission_id' );
            $vars = [
                'roles_privileges' => $roles_privileges,
                'menus'            => $menus,
                'role'             => $role,
            ];
            $this->tpl->assign( $vars );
            $this->tpl->display();
        }
    }

    public function save_power ()
    {
        $this->load->model( 'Roles_model' );
        $role_id = intval( _get( 'id' ) );
        $this->Roles_model->savePrivileges( _post( 'privileges' ), $role_id );
        $this->success_message( '保存成功', ADMIN_MANAGER_PATH );
    }
}
        
        