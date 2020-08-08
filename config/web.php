<?php

use app\models\Action;
use app\models\AdminVersion;
use app\models\Article;
use app\models\Cache;
use app\models\Category;
use app\models\Comment;
use app\models\Delivery;
use app\models\Design;
use app\models\DesignWidget;
use app\models\Favorite;
use app\models\FilterCategory;
use app\models\FilterProduct;
use app\models\Lang;
use app\models\Menu;
use app\models\MenuItem;
use app\models\Order;
use app\models\OrderReserve;
use app\models\Page;
use app\models\Payment;
use app\models\Product;
use app\models\ProductRests;
use app\models\ProductSeo;
use app\models\Promocode;
use app\models\SeoArticle;
use app\models\SeoFilter;
use app\models\SeoPage;
use app\models\SeoRedirect;
use app\models\SeoUrl;
use app\models\StaticTranslation;
use app\models\Text;
use app\models\Translation;
use app\models\User;
use app\models\Version;
use app\models\Widget;
use app\modules\pub\Module;
use app\urlRules\SeoUrlRule;
use app\virtual\Domains\AdminVersion\AdminVersionVm;
use app\virtualProviders\LoadWebVirtualProvidersComponent;
use kosuha606\VirtualAdmin\Domains\Cache\CacheVm;
use kosuha606\VirtualAdmin\Domains\Comment\CommentVm;
use kosuha606\VirtualAdmin\Domains\Design\DesignVm;
use kosuha606\VirtualAdmin\Domains\Design\DesignWidgetVm;
use kosuha606\VirtualAdmin\Domains\Design\WidgetVm;
use kosuha606\VirtualAdmin\Domains\Menu\MenuItemVm;
use kosuha606\VirtualAdmin\Domains\Menu\MenuVm;
use kosuha606\VirtualAdmin\Domains\Multilang\LangVm;
use kosuha606\VirtualAdmin\Domains\Multilang\StaticTranslationVm;
use kosuha606\VirtualAdmin\Domains\Multilang\TranslationVm;
use kosuha606\VirtualAdmin\Domains\Seo\SeoFilterVm;
use kosuha606\VirtualAdmin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualAdmin\Domains\Seo\SeoRedirectVm;
use kosuha606\VirtualAdmin\Domains\Seo\SeoUrlVm;
use kosuha606\VirtualAdmin\Domains\User\UserVm;
use kosuha606\VirtualAdmin\Domains\Version\VersionVm;
use kosuha606\VirtualContent\Domains\Article\Models\ArticleVm;
use kosuha606\VirtualContent\Domains\Article\Models\SeoArticleVm;
use kosuha606\VirtualContent\Domains\Page\Models\PageVm;
use kosuha606\VirtualContent\Domains\Text\Models\TextVm;
use kosuha606\VirtualShop\Model\ActionVm;
use kosuha606\VirtualShop\Model\CategoryVm;
use kosuha606\VirtualShop\Model\DeliveryVm;
use kosuha606\VirtualShop\Model\FavoriteVm;
use kosuha606\VirtualShop\Model\FilterCategoryVm;
use kosuha606\VirtualShop\Model\FilterProductVm;
use kosuha606\VirtualShop\Model\OrderReserveVm;
use kosuha606\VirtualShop\Model\OrderVm;
use kosuha606\VirtualShop\Model\PaymentVm;
use kosuha606\VirtualShop\Model\ProductRestsVm;
use kosuha606\VirtualShop\Model\ProductSeoVm;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualShop\Model\PromocodeVm;
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
    'modules' => [
        'pub' => [
            'class' => Module::class,
        ]
    ],
    'components' => [
        'providers_loader' => [
            'class' => LoadWebVirtualProvidersComponent::class,
            'arRelations' => [
                AdminVersionVm::class => [
                    'ar' => AdminVersion::class,
                ],
                CategoryVm::class => [
                    'ar' => Category::class
                ],
                StaticTranslationVm::class => [
                    'ar' => StaticTranslation::class
                ],
                SeoRedirectVm::class => [
                    'ar' => SeoRedirect::class
                ],
                SeoPageVm::class => [
                    'ar' => SeoPage::class,
                ],
                SeoFilterVm::class => [
                    'ar' => SeoFilter::class,
                ],
                SeoUrlVm::class => [
                    'ar' => SeoUrl::class
                ],
                VersionVm::class => [
                    'ar' => Version::class,
                ],
                LangVm::class => [
                    'ar' => Lang::class,
                ],
                TranslationVm::class => [
                    'ar' => Translation::class
                ],
                CacheVm::class => [
                    'ar' => Cache::class,
                ],
                CommentVm::class => [
                    'ar' => Comment::class,
                ],
                SeoArticleVm::class => [
                    'ar' => SeoArticle::class,
                ],
                TextVm::class => [
                    'ar' => Text::class,
                ],
                ArticleVm::class => [
                    'ar' => Article::class
                ],
                PageVm::class => [
                    'ar' => Page::class
                ],
                MenuVm::class => [
                    'ar' => Menu::class
                ],
                DesignVm::class => [
                    'ar' => Design::class
                ],
                DesignWidgetVm::class => [
                    'ar' => DesignWidget::class
                ],
                WidgetVm::class => [
                    'ar' => Widget::class
                ],
                MenuItemVm::class => [
                    'ar' => MenuItem::class
                ],
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
            'errorAction' => '/pub/site/error',
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
