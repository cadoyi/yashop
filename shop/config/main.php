<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id'       => 'app-shop',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'shop\controllers',
    'bootstrap' => [
        'log',
    ],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-shop',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-shop', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-shop',
            'class' => 'yii\redis\Session',
            'redis' => 'redisSession',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'linkAssets'      => true,
            'appendTimestamp' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix'         => '.html',
            'rules' => [
            ],
        ],
        'view' => [
            'class' => 'shop\components\View',
            'baseAsset' => 'shop\assets\AssetBundle',
        ],
        
    ],
    'params' => $params,
];
