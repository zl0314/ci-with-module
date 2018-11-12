<?php
/**
 * 系统设置表单验证项
 */
$validation_config = [];

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[username]',
        'label'  => lang( 'username' ),
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => lang( 'username' ) . lang( 'not_empty' ),
            'max_length' => lang( 'username' ) . lang( 'less_than_30' ),
        ],
    ],
    [
        'field'  => 'data[nickname]',
        'label'  => lang( 'display_name' ),
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => lang( 'display_name' ) . lang( 'not_empty' ),
            'max_length' => lang( 'display_name' ) . lang( 'less_than_30' ),
        ],
    ],
    [
        'field'  => 'data[password]',
        'label'  => lang( 'password' ),
        'rules'  => 'required_unless[data.id,0]|trim|newhtmlspecialchars',
        //required_unless 只有ID为空时， 密码为必须填
        'errors' => [
            'required_unless' => lang( 'password' ) . lang( 'not_empty' ),
            'min_length'      => lang( 'password' ) . lang( 'less_than_30' ),
        ],
    ],
];


return $validation_config;