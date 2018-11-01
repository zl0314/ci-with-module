<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/9/25 11:42
 * FileName : validation.php
 */

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[title]',
        'rules'  => 'required|trim|newhtmlspecialchars|max_length[150]',
        'errors' => [
            'required'   => '标题不能为空',
            'max_length' => '长度不能越过150'
        ],
    ],

    [
        'field'  => 'data[content]',
        'rules'  => 'required|trim|newhtmlspecialchars',
        'errors' => [
            'required'   => '内容不能为空',
        ],
    ],
];