<?php

/**
 * Created by PhpStorm.
 * User: zhang
 * Date: 2018/1/26
 * Time: 14:16
 */
class Adminuser extends Base_Controller
{
    public $statusArr;

    public function __construct ()
    {
        parent::__construct();
        $this->load->model( 'Adminuser_model' );

        $this->tb = 'adminuser';

        $this->statusArr = [
            '0' => lang( 'admin_user_normal' ),
            '1' => lang( 'admin_user_disabled' ),
        ];
        $this->isSuper = [
            '0' => lang( 'admin_user_no' ),
            '1' => lang( 'admin_user_yes' ),
        ];
        $this->tpl->assign( 'statusArr', $this->statusArr );

        $id = _get( 'id' );
        $this->adminRoles = $this->rs_model->getList( 'admin_user_role', '*', [ 'admin_user_id' => $id ] );
        $this->adminRoles = array_column( $this->adminRoles, 'role_id' );
    }

    /**
     * 创建时，默认数据
     *
     * @param string $variable
     */
    public function getInitData ( $variable = '', $data = [] )
    {
        $assign_var = $variable ? $variable : 'model';
        $initData = [
            'is_super' => '0',
            'status'   => 0,
        ];
        $data = !empty( $data ) ? $data : $initData;
        $this->tpl->assign( $assign_var, $data );
    }

    public function getData ()
    {
        $data = _post( 'data' );
        $data['addtime'] = date( 'Y-m-d H:i:s' );
        if ( empty( $data['password'] ) ) {
            unset( $data['password'] );
        } else {
            $data['password'] = password_hash( $data['password'], 1 );
        }
        unset( $data['roles'] );
        $returnData = [];
        $returnData['data'] = $data;

        return $returnData;
    }

    public function saveCallback ( $admin_user_id, $data = [] )
    {
        $data = _post( 'data' );
        if ( !empty( $data['roles'] ) ) {
            $this->Adminuser_model->saveRoles( $data['roles'], $admin_user_id );
        }
    }

}
