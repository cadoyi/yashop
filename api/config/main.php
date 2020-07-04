<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\modules\v1\controllers',
    'defaultRoute' => 'v1/index',
    'bootstrap' => ['log'],
    'modules' => require __DIR__ . '/main/modules.php',
    'components' => [
        'request' => [
            'enableCsrfCookie' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => 'json',
            'on beforeSend' => function($event) {
                $response = $event->sender;
                if($response->data !== null && Yii::$app->request->get('suppress_response_code')) {
                    $response->data = [
                       'success' => $response->isSuccessful,
                       'data' => $response->data,
                    ];
                    $response->statusCode = 200;
                }
            }
        ],
        'user' => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession'   => false,
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
        
        'urlManager' => require __DIR__ . '/main/v1/urlManager.php',
    ],
    'params' => $params,
];
