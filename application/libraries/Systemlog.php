<?php
/**
 * 系统日志类
 * Created by Aaron Zhang.
 * Date: 2018/11/14 16:52
 * FileName : Systemlog.php
 */

class Systemlog extends BaseLib
{
    public function __construct ()
    {
        parent::__construct();
    }

    /**
     * 保存日志
     *
     * @param string $msg
     * @param int    $success
     */
    public function saveLog ( $msg = '', $success = 1 )
    {
        $siteClass = $this->CI->data['siteclass'];
        $siteMethod = $this->CI->data['sitemethod'];
        $adminId = $this->CI->admin_info['id'];
        $menuIndex = $this->CI->menu->getMenuInfo( $siteClass, 'index' );
        $menuOpt = $this->CI->menu->getMenuInfo( $siteClass, $siteMethod );
        $pos = $menuIndex['name'] . '--' . $menuOpt['name'];
        $result = $success == 1 ? '成功' : '失败';
        $data = [
            'siteclass'  => $siteClass,
            'sitemethod' => $siteMethod,
            'addtime'    => date( 'Y-m-d H:i:s' ),
            'admin_id'   => $adminId,
            'msg'        => $msg,
            'pos'        => $pos,
            'result'     => $result,
        ];
        $this->CI->rs_model->save( 'system_logs', $data );
    }
}