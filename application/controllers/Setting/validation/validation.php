<?php
/**
 * 系统设置表单验证项
 */
$validation_config = [];

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[keys]',
        'label'  => 'KEY',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]|alpha_dash',
        'errors' => [
            'required'   => 'KEY不能为空',
            'alpha'   => 'KEY只能由字母纪组成',
            'max_length' => 'KEY长度不能超过30',
        ],
    ],
    [
        'field'  => 'data[value]',
        'label'  => '值',
        'rules'  => 'required|trim|newhtmlspecialchars',
        'errors' => [
            'required' => '值不能为空',
        ],
    ],
];


return $validation_config;