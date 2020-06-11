<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;
use app\virtualModels\Admin\Domains\Settings\SettingsService;
use app\widgets\Alert;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

// AppAsset::register($this);
// AdminAsset::register($this);

$settingsService = ServiceManager::getInstance()->get(SettingsService::class);

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
<body class="skin-blue">
<?php $this->beginBody() ?>

<div class="wrap">

    <div id="vue-app" v-cloak>
        <vue-topprogress ref="topProgress" :height="7" :color="'#0ff'"></vue-topprogress>

        <?= $this->render('_admin_template', [
            'content' => $content
        ])  ?>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
