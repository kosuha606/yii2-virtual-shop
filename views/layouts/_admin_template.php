<?php

use app\controllers\AdminController;
use app\virtualModels\Admin\Domains\Settings\SettingsService;
use app\widgets\Alert;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/** @var $content */
/** @var View $this */

/** @var AdminController $controller */
$controller = $this->context;

$route = Yii::$app->request->get('route');

$settingsService = ServiceManager::getInstance()->get(SettingsService::class);

?>


<div class="wrapper">
    <div class="main-header">
        <?php require_once '_admin_header.php' ?>
    </div>
    <div class="sidebar-wrapper">
        <?php require_once '_admin_sidebar.php' ?>
    </div>
    <div class="content-wrapper">

        <div class="row" id="main" >
            <div class="col-sm-12 col-md-12 well" id="content">
                <div class="container">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>

                    <?= $content ?>
                </div>
            </div>
        </div>

    </div>
    <footer class="main-footer">
        <strong>© <?= date('Y') ?></strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>VirtualModel</b>
        </div>
    </footer>
</div>

