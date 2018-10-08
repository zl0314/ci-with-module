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
        'field'  => 'data[nicekname]',
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
        'rules'  => 'required|trim|newhtmlspecialchars|min_length[6]|max_length[30]',
        'errors' => [
            'required'   => '密码不能为空',
            'min_length' => '密码长度不能小于6位',
            'max_length' => '密码长度不能超过30',
        ],
    ],
];


return $validation_config;