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
    ],
    [
        'field' => 'data[site_keyword]',
        'label' => '关键字',
        'rules' => 'required|trim|newhtmlspecialchars',
    ],
    [
        'field' => 'data[site_description]',
        'label' => '站点描述',
        'rules' => 'trim|newhtmlspecialchars|max_length[100]',
    ],
];


return $validation_config;