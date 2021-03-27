<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use kosuha606\VirtualAdmin\Domains\Design\DesignService;
use kosuha606\VirtualShop\ServiceManager;
use yii\helpers\Html;

AppAsset::register($this);

$user = ServiceManager::getInstance()->userService->current();
$cart = ServiceManager::getInstance()->cartBuilder->getCart();

$designService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(DesignService::class);

$alert = Alert::widget();

$content = $alert.$content;
$route = \Yii::$app->requestedRoute ?: 'site/index';

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

<?= $designService->renderDesignForRoute($route, $content) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
