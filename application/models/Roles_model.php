<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/8/30 18:12
 * FileName : Adminuser_model.php
 */

class Roles_model extends CI_Model
{

    /**
     * 保存角色权限信息
     *
     * @param $roles         权限数组
     * @param $admin_user_id 角色ID
     */
    public function savePrivileges ( $permission, $role_id )
    {
        //删除所有 角色所有的权限
        $where = [
            'role_id' => $role_id,
        ];
        $this->rs_model->delete( 'privileges_role', $where );

        //重新插入
        foreach ( $permission as $k => $permission_id ) {
            $saveData = [
                'permission_id' => $k,
                'role_id'       => $role_id,
            ];
            $this->rs_model->save( 'privileges_role', $saveData );
        }

    }
}