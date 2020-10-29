<?php
/**
 * 后台配置
 *
 * 
 */
return [
    'tabs' => [
        'general' => [
            'label' => 'General',
        ],
        'customer' => [
            'label' => 'Customer',
        ],
        'admin' => [
            'label' => 'Admin',
        ],
    ],
    'sections' => [
       'web'       => require __DIR__ . '/system/web.php',
       'login'     => require __DIR__ . '/system/login.php',
       'customer'  => require __DIR__ . '/system/customer.php',
       'oauth'     => require __DIR__ . '/system/oauth.php', 
    ],
];