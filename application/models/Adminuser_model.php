<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/8/30 18:12
 * FileName : Adminuser_model.php
 */

class Adminuser_model extends CI_Model
{

    /**
     * 保存管理员的角色信息
     *
     * @param $roles         角色数组
     * @param $admin_user_id 管理员ID
     */
    public function saveRoles ( $roles, $admin_user_id )
    {
        //删除所有 管理员所属的角色
        $where = [
            'admin_user_id' => $admin_user_id,
        ];
        $this->rs_model->delete( 'admin_user_role', $where );

        //重新插入
        foreach ( $roles as $k => $role_id ) {
            $saveData = [
                'admin_user_id' => $admin_user_id,
                'role_id'       => $role_id,
            ];
            $this->rs_model->save( 'admin_user_role', $saveData );
        }

    }
}