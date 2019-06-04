<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'layout' => 'main',
    'modules' => [
        'system' => [
            'class' => 'system\Module',
        ],
        'rbac' => [
            'class' => 'rbac\Module',
        ],
    ],
    "aliases" => [
        '@rbac' => '@backend/modules/rbac',
        '@system' => '@backend/modules/system',
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'rbac\models\User',
            'loginUrl' => array('/rbac/user/login'),
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        "authManager" => [
            "class" => 'yii\rbac\DbManager',
            "defaultRoles" => ["guest"],
        ],
        "i18n" => [
            "translations" => [
                "*" => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@rbac/messages'
                ]
            ]
        ],
        "urlManager" => [
            "enablePrettyUrl" => true,
            "enableStrictParsing" => false,
            "showScriptName" => true,
            "suffix" => "",
//            "rules" => [
//                "<controller:\w+>/<id:\d+>"=>"<controller>/view",
//                "<controller:\w+>/<action:\w+>"=>"<controller>/<action>"
//            ],
        ],
    ],
    'as access' => [
        'class' => 'rbac\components\AccessControl',
        'allowActions' => [
            'rbac/user/logout',
            'rbac/user/request-password-reset',
            'rbac/user/reset-password',
            'system/index/welcome'
        ]
    ],
    'params' => $params,
];
