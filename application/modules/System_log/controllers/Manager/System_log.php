<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class System_log extends Base_Controller
{
    public function __construct ()
    {
        $this->tb = 'system_logs';
        parent::__construct();
        $this->listorder = 'system_logs.id desc';
    }

    public function getWhere ()
    {
        $where = [
            'join' => [ 'adminuser admin', 'admin.id=system_logs.admin_id', 'left' ],
        ];
        if ( _get( 'start_time' ) ) {
            $where['created_at <='] = _get( 'start_time' );
        }
        if ( _get( 'end_time' ) && _get( 'start_time' ) ) {
            $where['created_at >='] = _get( 'start_time' );
            $where['created_at <='] = _get( 'end_time' );
        }

        return $where;
    }

    public function getField ()
    {
        return 'system_logs.*,admin.nickname as admin_name';
    }

}
        
        