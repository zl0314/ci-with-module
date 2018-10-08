<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/9/25 11:42
 * FileName : validation.php
 */

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[name]',
        'label'  => 'name',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[30]',
        'errors' => [
            'required'   => '角色名不能为空',
            'max_length' => '角色长度不能超过30',
        ],
    ],
];