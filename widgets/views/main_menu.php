<?php


use kosuha606\VirtualAdmin\Domains\Multilang\LangVm;
use kosuha606\VirtualAdmin\Domains\Multilang\TranslationService;
use kosuha606\VirtualAdmin\Domains\Settings\SettingsService;
use kosuha606\VirtualShop\ServiceManager;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

/** @var LangVm[] $languages */

$user = ServiceManager::getInstance()->userService->current();
$cart = ServiceManager::getInstance()->cartBuilder->getCart();

$translationService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(TranslationService::class);
$langsbar = '';

if (count($languages) > 1) {
    $langsbar = '<li class="langs">';

    /** @var LangVm $language */
    foreach ($languages as $language) {
        $langsbar .= Html::a($language->code, ['site/lang', 'l' => $language->code]);
    }

    $langsbar .= '</li>';
}

$settingsService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(SettingsService::class);

NavBar::begin([
    'brandLabel' =>
    Html::img('/'.$settingsService->setting('site_logo'), ['style' => 'margin-right: 10px;width: 23px;vertical-align: top;display: inline-block;']).
        Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);


echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        $langsbar,
        ['label' => $translationService->translate('Каталог'), 'url' => ['/site/index']],
        ['label' => $translationService->translate('Поиск'), 'url' => ['/site/search']],
        [
            'label' => $cart->getAmount()
                ? ($translationService->translate('В корзине: ') . $cart->getAmount() . ' шт. на ' . $cart->getTotals() . ' руб.')
                : $translationService->translate('Корзина')
            ,
            'url' => ['/cart/index'],
        ],
        ($user ? ($user->isAdmin() ? ['label' => $translationService->translate('Админка'), 'url' => '/admin'] : '') : '')
        ,
        Yii::$app->user->isGuest ? (
        ['label' => $translationService->translate('Вход'), 'url' => ['/guest/login']]
        ) : (
            '<li>'
            .Html::a($translationService->translate('Кабинет'), ['cabinet/orders'])
            . '</li>'
            .'<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                $translationService->translate('Выход').'(' . Yii::$app->user->identity->username . ')',
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
    <input value="<?= Html::encode($q) ?>" name="q" class="form-control mr-sm-2" type="search"
           placeholder="<?= $translationService->translate('Введите запрос') ?>"
           aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
        <?= $translationService->translate('Найти') ?>
    </button>
</form>
</div>
<?php
NavBar::end();
?>
