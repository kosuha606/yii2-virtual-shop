<?php

use app\virtualProviders\ActiveRecordProvider;
use app\virtualProviders\LoadWebVirtualProvidersComponent;
use kosuha606\VirtualModel\Example\Product\Product;
use kosuha606\VirtualModel\Example\Shop\Model\Action;
use kosuha606\VirtualModel\Example\Shop\Model\Delivery;
use kosuha606\VirtualModel\Example\Shop\Model\Order;
use kosuha606\VirtualModel\Example\Shop\Model\OrderReserve;
use kosuha606\VirtualModel\Example\Shop\Model\Payment;
use kosuha606\VirtualModel\Example\Shop\Model\ProductRests;
use kosuha606\VirtualModel\Example\Shop\Model\Promocode;
use yii\db\ActiveRecord;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Virtual Shop',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'providers_loader'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'providers_loader' => [
            'class' => LoadWebVirtualProvidersComponent::class,
            'arRelations' => [
                Action::class => \app\models\Action::class,
                Delivery::class => \app\models\Delivery::class,
                Order::class => \app\models\Order::class,
                OrderReserve::class => \app\models\OrderReserve::class,
                Payment::class => \app\models\Payment::class,
                Product::class => \app\models\Product::class,
                ProductRests::class => \app\models\Product::class,
                Promocode::class => \app\models\Promocode::class
            ]
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
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
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
