<?php

return [
    // id  => config
    'storage' => 'storage',
    'paths' => [
        'admin/user/avatar' => [
            'type'       => 'image',
            'path'       => 'admin/user/avatar',
            'validators' => [
                ['required'],
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
        'customer/customer/avatar' => [
            'type'       => 'image',
            'path'       => 'customer/customer/avatar',
            'validators' => [
                ['required'],
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
        'catalog/brand/logo' => [
            'type' => 'image',
            'path' => 'catalog/brand/logo',
            'validators' => [
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
        'catalog/product/image' => [
            'type' => 'image',
            'path' => 'catalog/product/image',
            'validators' => [
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
        'catalog/product/images' => [
            'type'  => 'image',
            'path'  => 'catalog/product/images',
            'level' => 2,
            'validators' => [
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
        'catalog/product/gallery' => [
            'type'  => 'image',
            'path'  => 'catalog/product/gallery',
            'level' => 2,
            'validators' => [
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
        'store/store/logo' => [
            'type' => 'image',
            'path' => 'store/store/logo',
            'validators' => [
                ['image', 'extensions' => ['jpg', 'png', 'jpeg', 'gif']],
            ],
        ],
    ],
];