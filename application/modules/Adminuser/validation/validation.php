<?php
/**
 * 系统设置表单验证项
 */
$validation_config = [];

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[username]',
        'label'  => '名称',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => '用户名不能为空',
            'max_length' => '用户名长度不能超过30',
        ],
    ],
    [
        'field'  => 'data[nickname]',
        'label'  => '昵称',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => '昵称不能为空',
            'max_length' => '昵称长度不能超过30',
        ],
    ],
    [
        'field'  => 'data[password]',
        'label'  => '密码',
        'rules'  => 'required_unless[data.id,0]|trim|newhtmlspecialchars',
        //required_unless 只有ID为空时， 密码为必须填
        'errors' => [
            'required_unless' => '密码不能为空',
            'min_length'      => '密码长度不能小于6位',
        ],
    ],
];


return $validation_config;