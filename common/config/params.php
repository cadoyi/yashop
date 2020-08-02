<?php
return [
    'models' => [
        'fields' => [
            'gender' => [
                0 => 'Male',
                1 => 'Female',
            ],
        ],
    ],
    'catalog' => [
        'type' => [
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
                ],
                'select' => [
                    'label'     => 'Dropdown list',
                    'values'    => true,
                ],
                'multiselect' => [
                    'label'     => 'Multiple select dropdown list',
                    'values'    => true,
                ],
                'radio'  => [
                    'label'    => 'Radio input',
                    'values'   => true,
                ],
                'radiolist' => [
                    'label'   => 'Radio list',
                    'values'  => true,
                ],
                'checkbox' => [ 
                    'label'  => 'Checkbox input',
                    'values' => true,
                ],
                'checkboxlist' => [
                    'label' => 'Checkbox list',
                    'values' => true,
                ],
                'boolean'  => [
                    'label' => 'Boolean input',
                    'values' => true,
                ],
            ],
        ],
    ],
];
