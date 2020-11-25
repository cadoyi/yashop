<?php
/**
 * 后台配置
 *
 * 
 */
return [
    'tabs' => [
        'general' => [
            'label' => 'General settings',
        ],
        'customer' => [
            'label' => 'Customer settings',
        ],
        'admin' => [
            'label' => 'Admin settings',
        ],
       // 'store' => [
        //     'label' => 'Store settings',
        //],
    ],
    'sections' => [
       'web'       => require __DIR__ . '/system/web.php',
       'url'       => require __DIR__ . '/system/url.php',
       'login'     => require __DIR__ . '/system/login.php',
       'customer'  => require __DIR__ . '/system/customer.php',
       'oauth'     => require __DIR__ . '/system/oauth.php',
       //'store'     => require __DIR__ . '/system/store.php',
    ],
];