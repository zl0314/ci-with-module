<?php if ( !defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Setting extends Base_Controller
{
    public function __construct ()
    {
        $this->tb = 'settings';
        $this->hasCreated = true;

        parent::__construct();

        $typeArr = [
            '1' => '文本框',
            '2' => '图片',
            '3' => '富文本',
        ];
        $this->tpl->assign( 'typeArr', $typeArr );
    }


}
