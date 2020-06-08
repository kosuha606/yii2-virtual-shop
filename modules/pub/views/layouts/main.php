<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\virtualModels\Domains\Design\Services\DesignService;
use app\virtualModels\Domains\Menu\Widgets\MenuWidget;
use app\virtualModels\ServiceManager;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$user = ServiceManager::getInstance()->userService->current();
$cart = ServiceManager::getInstance()->cartBuilder->getCart();

$designService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(DesignService::class);

$alert = Alert::widget();

$content = $alert.$content;

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
</head>
<body>
<?php $this->beginBody() ?>

<?= $designService->renderDesignForRoute($content) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
