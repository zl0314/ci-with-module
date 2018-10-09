<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/10/8 14:37
 * FileName : MY_Form_validation.php
 */

class MY_Form_validation extends CI_Form_validation
{
    public function __construct ()
    {
        parent::__construct();
    }


    /**
     * required_unless[data.id,0],只有ID为空时， 密码为必须填
     *
     * @param $str = 用户输入的密码
     * @param $val  = data.id,0
     *
     * @return bool
     */
    public function required_unless ( $str, $val )
    {
        $return = false;
        $data = $this->validation_data;
        if ( strpos( $val, '.' ) !== false ) {
            $key = substr( $val, 0, strpos( $val, '.' ) );
            $need = substr( $val, strpos( $val, '.' ) + 1 );

            $arr = explode( ',', $need );
            if ( !empty( $key ) ) {
                if ( intval( $data[ $key ][ $arr[0] ] ) == $arr[1] ) {
                    $return = false;
                } else {
                    $return = true;
                }
            } else {
                if ( intval( $data[ $arr[0] ] ) == $arr[1] ) {
                    $return = false;
                } else {
                    $return = true;
                }
            }
        }

        return $return;
    }

}