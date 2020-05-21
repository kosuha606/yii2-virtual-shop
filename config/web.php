<?php

use app\models\Action;
use app\models\Delivery;
use app\models\Favorite;
use app\models\FilterCategory;
use app\models\FilterProduct;
use app\models\Order;
use app\models\OrderReserve;
use app\models\Payment;
use app\models\Product;
use app\models\ProductRests;
use app\models\ProductSeo;
use app\models\Promocode;
use app\models\User;
use app\virtualModels\Model\ActionVm;
use app\virtualModels\Model\DeliveryVm;
use app\virtualModels\Model\FavoriteVm;
use app\virtualModels\Model\FilterCategoryVm;
use app\virtualModels\Model\FilterProductVm;
use app\virtualModels\Model\OrderVm;
use app\virtualModels\Model\OrderReserveVm;
use app\virtualModels\Model\PaymentVm;
use app\virtualModels\Model\ProductSeoVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\ProductRestsVm;
use app\virtualModels\Model\PromocodeVm;
use app\virtualModels\Model\UserVm;
use app\virtualProviders\LoadWebVirtualProvidersComponent;
use yii\db\ActiveRecord;

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
    'components' => [
        'providers_loader' => [
            'class' => LoadWebVirtualProvidersComponent::class,
            'arRelations' => [
                FilterProductVm::class => [
                    'ar' => FilterProduct::class
                ],
                FilterCategoryVm::class => [
                    'ar' => FilterCategory::class
                ],
                ActionVm::class => [
                    'ar' => Action::class,
                ],
                FavoriteVm::class => [
                    'ar' => Favorite::class,
                    'with' => ['product', 'user']
                ],
                DeliveryVm::class => [
                    'ar' => Delivery::class,
                ],
                OrderVm::class => [
                    'ar' => Order::class,
                ],
                OrderReserveVm::class => [
                    'ar' => OrderReserve::class,
                ],
                PaymentVm::class => [
                    'ar' => Payment::class,
                ],
                ProductVm::class => [
                    'ar' => Product::class,
                ],
                ProductRestsVm::class => [
                    'ar' => ProductRests::class,
                ],
                ProductSeoVm::class => [
                    'ar' => ProductSeo::class,
                ],
                PromocodeVm::class => [
                    'ar' => Promocode::class
                ],
                UserVm::class => [
                    'ar' => User::class,
                ]
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/admin' => '/admin/index',
                '/admin/<route>/<act>' => '/admin/processor'
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['192.168.10.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
