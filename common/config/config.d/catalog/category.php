<?php

/**
 * 分类相关的配置
 * 
 */
return [
    'input_type' => [
        'text' => [
            'label'  => 'Text input',
            'values' => false,
        ],
        'textarea' => [
            'label'  => 'Multiple line text input',
            'values' => false,
        ],
        'boolean' => [
            'label'  => 'Boolean input',
            'values' => true,
            'hint'   => '大概这样 { "yes": "yes", "no": "no" }',
        ],
        'select' => [
            'label'     => 'Dropdown list',
            'values'    => true,
            'hint'      => '大概这样 { "k": "v", "k2": "v2" }',
        ],
        'multiselect' => [
            'label'     => 'Multiple select dropdown list',
            'values'    => true,
            "hint"      => '大概这样 { "k": "v", "k2": "v2" }',
        ],
        'radio'  => [
            'label'    => 'Radio input',
            'values'   => true,
            "hint"     => '大概这样 { "1" => "男" }',
        ],
        'radiolist' => [
            'label'   => 'Radio list',
            'values'  => true,
            "hint"      => '大概这样 { "k": "v", "k2": "v2" }',
        ],
        'checkbox' => [ 
            'label'  => 'Checkbox input',
            'values' => true,
            "hint"      => '大概这样 { "k": "v"}',
        ],
        'checkboxlist' => [
            'label' => 'Checkbox list',
            'values' => true,
            "hint"      => '大概这样 { "k": "v", "k2": "v2" }',
        ],
    ],
];