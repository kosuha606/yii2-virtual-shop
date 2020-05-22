<?php


use app\virtualModels\ServiceManager;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

$user = ServiceManager::getInstance()->userService->current();
$cart = ServiceManager::getInstance()->cartBuilder->getCart();

NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        ['label' => 'Каталог', 'url' => ['/site/index']],
        [
            'label' => $cart->getAmount()
                ? ('В корзине: ' . $cart->getAmount() . ' шт. на ' . $cart->getTotals() . ' руб.')
                : 'Корзина'
            ,
            'url' => ['/cart/index'],
        ],
        ($user ? ($user->isAdmin() ? ['label' => 'Админка', 'url' => '/admin'] : '') : '')
        ,
        Yii::$app->user->isGuest ? (
        ['label' => 'Вход', 'url' => ['/guest/login']]
        ) : (
            '<li>'
            .Html::a('Кабинет', ['cabinet/orders'])
            . '</li>'
            .'<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Выход (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        ),
    ],
]);
NavBar::end();
?>
