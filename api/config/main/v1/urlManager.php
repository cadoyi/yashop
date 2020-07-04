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
        ['controller' => 'v1/index', 'patterns' => ['GET' => 'index'] ],
    ],
];