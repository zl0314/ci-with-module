<?php
/**
 * 系统设置表单验证项
 */
$validation_config = [];

//后台验证
$validation_config['manager'] = [
    [
        'field' => 'data[site_title]',
        'label' => '站点标题',
        'rules' => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required' => '站点标题不能为空',
            'max_length' => '站点标题长度不能超过30'
        ],
    ],
    [
        'field' => 'data[site_keyword]',
        'label' => '关键字',
        'rules' => 'trim|newhtmlspecialchars',

    ],
    [
        'field' => 'data[site_description]',
        'label' => '站点描述',
        'rules' => 'trim|newhtmlspecialchars|max_length[100]',
        'errors' => [
            'required' => '站点描述不能为空',
            'max_length' => '站点描述长度不能超过100'
        ],
    ],
];


return $validation_config;