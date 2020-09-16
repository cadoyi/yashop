<?php

/**
 * url manager for v1
 * 
 */
return [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => true,
    'cache' => false,
    'ruleConfig' => [
       'class' => 'yii\rest\UrlRule',
    ],
    'rules' => [
        [
            'prefix'       => 'v1',
            'controller'   => ['indices' => 'v1/index'],
            'patterns'     => [
                'GET,HEAD' => 'index',
            ], 
        ],
    ],
];