<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Setting extends Base_Controller
{
    public function __construct ()
    {
        $this->tb = 'settings';
        $this->hasCreated = true;

        parent::__construct();
        //只有常量LANG_ON为TRUE 时， 才有效
        //echo lang( 'test' );

        $this->load->config( 'Setting/config' );

        $typeArr = [
            '1' => '文本框',
            '2' => '图片',
            '3' => '富文本',
        ];
        $this->tpl->assign( 'typeArr', $typeArr );
    }


}
