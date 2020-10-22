<?php
/**
 * view's theme
 * 
 */

return [
    'basePath' => '@themePath',
    'baseUrl'  => '@themeSkin',
    'pathMap' => [
        '@backend/views' => [
            '@themePath',
        ],
        '@modules' => [
            '@themePath',
        ],
    ],        
];