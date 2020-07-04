<?php
/**
 * view's theme
 * 
 */
return [
    'basePath' => '@backend/themes',
    'baseUrl'  => '@web/skin/basic',
    'pathMap' => [
        '@backend/views' => [
            '@backend/themes/basic',
        ],
        
        // core module
        '@modules/core/backend/views/layouts' => [
            '@backend/themes/basic/core/layouts',
            '@backend/themes/basic/layouts',
        ],
        '@modules/core/backend/views' => [
            '@backend/themes/basic/core',
        ],

        // admin module
        '@modules/admin/backend/views/layouts' => [
            '@backend/themes/basic/admin/layouts',
            '@backend/themes/basic/layouts',
        ],
        '@modules/admin/backend/views' => [
            '@backend/themes/basic/admin',
        ],
    ],
            
];