<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
AdminAsset::register($this);

$this->registerJsVar('webpack_asset_path', '/srcadmin/dist/');

$this->registerJsFile('/srcadmin/dist/admin.js');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="manifest" href="/admin/dist/mix-manifest.json">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
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
            ['label' => 'Главная', 'url' => ['/site/index']],
            Yii::$app->user->isGuest ? (
            ['label' => 'Вход', 'url' => ['/guest/login']]
            ) : (
                '<li>'
                .Html::a('Кабинет', ['cabinet/profile'])
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

    <div id="vue-app">
        <?= $this->render('_admin_template', [
            'content' => $content
        ])  ?>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">
            <a target="_blank" href="https://github.com/kosuha606">
                &copy; kosuha606
            </a>
            <?= date('Y') ?></p>

        <p class="pull-right">
            Based on
            <a target="_blank" href="https://github.com/kosuha606/virtual-model">
                VirtualModel
            </a>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
