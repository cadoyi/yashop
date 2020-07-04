<?php

return [
    'version' => '0.0.4',
    'roles' =>  ['admin'],
    'permissions' => [
        'post' => [
            'label' => 'Post',
        ],
        'post/create' => [
            'label' => 'Create post',
            'parents' => ['post'],
        ],
        'post/update' => [
            'label' => 'Update post',
            'parents' => ['post', 'post/update/owner'],
        ],
        'post/update/owner' => [
            'label' => 'Only update my post',
            'rule_name' => 'cando\\rbac\\rules\\Owner',
        ],
        'post/view' => [
           'parents' => ['post'],
        ],
        'post/delete' => [
            'label' => 'Delete post',
            'parents' => ['post'],
        ],
    ],

];