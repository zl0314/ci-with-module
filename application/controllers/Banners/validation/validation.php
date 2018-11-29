<?php
/**
 * Created by Aaron Zhang.
 * Date: 2018/9/25 11:42
 * FileName : validation.php
 */

//后台验证
$validation_config['manager'] = [
    [
        'field'  => 'data[customer_pos]',
        'label'  => 'customer_pos',
        'rules'  => 'required|trim|newhtmlspecialchars|regex_match[/[a-zA-Z\-_]+/i]|max_length[40]',
        'errors' => [
            'required'   => '自定义位置不能',
            'regex_match'   => '自定义位置只能包含字母下划线中横线',
            'max_length' => '自定义位置长度不能超过40',
        ],
    ],

    [
        'field'  => 'data[image]',
        'label'  => 'image',
        'rules'  => 'required|trim|newhtmlspecialchars',
        'errors' => [
            'required'   => '图片不能为空',
        ],
    ],
];