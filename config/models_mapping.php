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
use app\virtual\Domains\AdminVersion\AdminVersionVm;
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

return [
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
];
