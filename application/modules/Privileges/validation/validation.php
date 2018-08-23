<?php
/**
 * 系统设置表单验证项
 */
$validation_config = [];

//后台验证
$validation_config['manager'] = [
    [
        'field' => 'data[name]',
        'label' => '名称',
        'rules' => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required' => '名称不能为空',
            'max_length' => '名称长度不能超过30'
        ],
    ],
];


return $validation_config;