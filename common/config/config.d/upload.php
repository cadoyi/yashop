<?php

return [
    // id  => config
    'storage' => [
        'class'   => 'core\models\file\storage\Local',
        'root'    => '@media',
        'baseUrl' => '@mediaUrl',
    ],
    'paths' => [
        'admin/user/avatar' => [
            'type'       => 'image',
            'path'       => 'admin/user/avatar',
            'validators' => [
                ['image', 'required'],
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],

        ],
    ],
];