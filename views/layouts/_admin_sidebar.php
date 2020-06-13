<?php


use yii\helpers\Html;

$pathInfo = '/'.Yii::$app->request->pathInfo;

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <?=  Html::img('/'.$settingsService->setting('site_logo'),
            [
                'class' => 'brand-image img-circle elevation-3'
            ]) ?>
        <span class="brand-text font-weight-light">AdminPane</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
<!--        <div class="user-panel mt-3 pb-3 mb-3 d-flex">-->
<!--            <div class="image">-->
<!--                <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
<!--            </div>-->
<!--            <div class="info">-->
<!--                <a href="#" class="d-block">Alexander Pierce</a>-->
<!--            </div>-->
<!--        </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <?php foreach ($controller->menu as $menu) { ?>
                    <?php if (isset($menu['visible']) && $menu['visible'] === false) { ?>
                        <?php continue; ?>
                    <?php } ?>
                    <?php
                    $isActive = false;
                    if (isset($menu['children'])) {
                        $childrentNames = array_column($menu['children'], 'name');
                        foreach ($childrentNames as $childrentName) {
                            if (strpos($childrentName, $route) !== false) {
                                $isActive = true;
                                break;
                            }
                        }
                    }
                    ?>
                    <li class="nav-item has-treeview <?= $isActive ? 'menu-open' : '' ?>">
                        <?php if (isset($menu['url'])) { ?>
                            <?php
                            $isSubActive = $pathInfo === $menu['url'];
                            ?>
                            <a  class="nav-link <?= $isSubActive ? 'active' : '' ?>" href="<?= $menu['url'] ?>" data-target="#<?= $menu['name'] ?>">
                                <?= $menu['label'] ?>
                            </a>
                        <?php } else { ?>
                            <a class="nav-link" href="#" data-target="#<?= $menu['name'] ?>">
                                <p>
                                    <?= $menu['label'] ?>
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                        <?php } ?>
                        <?php if (isset($menu['children'])) { ?>
                            <ul id="<?= $menu['name'] ?>" class="nav nav-treeview <?= $isActive ? 'in' : '' ?>">
                                <?php foreach ($menu['children'] as $menuChild) { ?>
                                    <?php if (isset($menuChild['visible']) && $menuChild['visible'] === false) { ?>
                                        <?php continue; ?>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <?php
                                        $isSubActive = $pathInfo === $menuChild['url'];
                                        ?>
                                        <a class="nav-link <?= $isSubActive ? 'active' : '' ?>" href="<?= $menuChild['url'] ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                <?= $menuChild['label'] ?>
                                            </p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
