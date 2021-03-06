<?php

/* @var $this View */

/* @var $content string */

use app\assets\VirtualAdminAsset;
use kosuha606\VirtualAdmin\Domains\Settings\SettingsService;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Html;
use yii\web\View;

$settingsService = ServiceManager::getInstance()->get(SettingsService::class);

$bundle = VirtualAdminAsset::register($this);

$this->registerJsVar('webpack_asset_path', $bundle->baseUrl.'/');

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
    <style>
        html :not(body[style]) {
            font-size: 1rem;
        }
    </style>
</head>
<body class="skin-blue">
<?php $this->beginBody() ?>

<div class="wrap">
    <div id="vue-app" v-cloak>
        <vue-topprogress ref="topProgress" :height="7" :color="'#007bff'"></vue-topprogress>

        <?= $this->render(
            '_admin_template',
            [
                'content' => $content,
            ]
        ) ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
