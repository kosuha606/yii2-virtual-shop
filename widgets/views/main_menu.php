<?php


use app\virtualModels\Domains\Multilang\LangVm;
use app\virtualModels\ServiceManager;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/** @var LangVm[] $languages */

$user = ServiceManager::getInstance()->userService->current();
$cart = ServiceManager::getInstance()->cartBuilder->getCart();

$langsbar = '<li class="langs">';

/** @var LangVm $language */
foreach ($languages as $language) {
    $langsbar .= Html::a($language->code, ['site/lang', 'l' => $language->code]);
}

$langsbar .= '</li>';

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
        $langsbar,
        ['label' => 'Каталог', 'url' => ['/site/index']],
        ['label' => 'Поиск', 'url' => ['/site/search']],
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

$q = Yii::$app->request->get('q', '');
?>
<div style="padding: 8px">
<form action="/site/search" method="get" class="form-inline my-2 my-lg-0">
    <input value="<?= Html::encode($q) ?>" name="q" class="form-control mr-sm-2" type="search" placeholder="Введите запрос" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Найти</button>
</form>
</div>
<?php
NavBar::end();
?>
