<?php
/**
 * 系统设置表单验证项
 */
$validation_config = [];

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[name]',
        'label'  => '名称',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => '名称不能为空',
            'max_length' => '名称长度不能超过30',
        ],
    ],
    [
        'field'  => 'data[controller]',
        'label'  => '控制器',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => '控制器不能为空',
            'max_length' => '控制器长度不能超过30',
        ],
    ],
    [
        'field'  => 'data[method]',
        'label'  => '方法',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => '方法不能为空',
            'max_length' => '方法长度不能超过30',
        ],
    ],
    [
        'field'  => 'data[show_at]',
        'label'  => '显示位置',
        'rules'  => 'required|trim|newhtmlspecialchars',
        'errors' => [
            'required' => '显示位置不能为空',
        ],
    ],
    [
        'field'  => 'data[parent_id]',
        'label'  => '上级菜单',
        'rules'  => 'trim|newhtmlspecialchars',
        'errors' => [
            'required' => '上级菜单不能为空',
        ],
    ],
];


return $validation_config;