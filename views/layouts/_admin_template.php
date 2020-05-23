<?php

use app\controllers\AdminController;
use app\widgets\Alert;
use http\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/** @var $content */
/** @var View $this */

/** @var AdminController $controller */
$controller = $this->context;

$route = Yii::$app->request->get('route');

?>


<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand pt-20" href="/" style="padding-top: 18px">
                AdminPane
            </a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li><a href="#" data-placement="bottom" data-toggle="tooltip" href="#" data-original-title="Stats"><i class="fa fa-bar-chart-o"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Администратор <b class="fa fa-angle-down"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa fa-fw fa-user"></i> Профиль</a></li>
                    <li class="divider"></li>
                    <li>
                        <?php
                        echo Html::beginForm(['/site/logout'], 'post');
                        echo Html::submitButton(
                        '<i class="fa fa-fw fa-power-off"></i> Выход',
                        ['class' => 'btn ']
                        );
                        echo Html::endForm();
                        ?>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <?php foreach ($controller->menu as $menu) { ?>
                    <?php if (isset($menu['visible']) && $menu['visible'] === false) { ?>
                        <?php continue; ?>
                    <?php } ?>
                    <li>
                        <?php if (isset($menu['url'])) { ?>
                            <a href="<?= $menu['url'] ?>" data-toggle="collapse" data-target="#<?= $menu['name'] ?>">
                                <?= $menu['label'] ?>
                            </a>
                        <?php } else { ?>
                            <a href="#" data-toggle="collapse" data-target="#<?= $menu['name'] ?>">
                                <?= $menu['label'] ?>
                                &darr;
                            </a>
                        <?php } ?>
                        <?php if (isset($menu['children'])) { ?>
                            <?php
                            $isActive = false;
                            $childrentNames = array_column($menu['children'], 'name');
                            foreach ($childrentNames as $childrentName) {
                                if (strpos($childrentName, $route) !== false) {
                                    $isActive = true;
                                    break;
                                }
                            }

                            $k = 1;
                            ?>
                        <ul id="<?= $menu['name'] ?>" class="collapse <?= $isActive ? 'in' : '' ?>">
                            <?php foreach ($menu['children'] as $menuChild) { ?>
                                <?php if (isset($menuChild['visible']) && $menuChild['visible'] === false) { ?>
                                    <?php continue; ?>
                                <?php } ?>
                                <li>
                                    <a href="<?= $menuChild['url'] ?>">
                                        <?= $menuChild['label'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
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
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
</div><!-- /#wrapper -->
