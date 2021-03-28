<?php

use app\modules\pub\Module;
use app\urlRules\SeoUrlRule;
use app\virtualProviders\LoadWebVirtualProvidersComponent;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'VirtualShop <sub>demo</sub>',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'providers_loader'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'pub' => [
            'class' => Module::class,
        ]
    ],
    'components' => [
        'providers_loader' => [
            'class' => LoadWebVirtualProvidersComponent::class,
            'arRelations' => require 'models_mapping.php',
        ],
        'request' => [
            'cookieValidationKey' => 'Giq-5QZlBkAbp2-i3hdj72z897J8_8r1',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => '/pub/site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
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
        'db' => $db,
        'assetManager' => [
            'linkAssets' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => SeoUrlRule::class,
                ],
                '/admin' => '/admin/index',
                '/admin/<route>/<act>' => '/admin/processor',
                '/news' => '/pub/article/list',
                '/' => '/pub/site/index',
                '/<controller>/<action>' => '/pub/<controller>/<action>',
                'sitemap.xml' => '/pub/site/sitemap',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
