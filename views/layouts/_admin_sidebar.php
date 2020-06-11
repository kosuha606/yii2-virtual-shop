<?php


use yii\helpers\Html; ?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <?=  Html::img('/'.$settingsService->setting('site_logo'), ['style' => 'width: 23px;vertical-align: top;display: inline-block;']) ?>
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
                    <li class="nav-item has-treeview menu-open">
                        <?php if (isset($menu['url'])) { ?>
                            <a  class="nav-link active" href="<?= $menu['url'] ?>" data-toggle="collapse" data-target="#<?= $menu['name'] ?>">
                                <?= $menu['label'] ?>
                            </a>
                        <?php } else { ?>
                            <a class="nav-link active" href="#" data-toggle="collapse" data-target="#<?= $menu['name'] ?>">
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
                            <ul id="<?= $menu['name'] ?>" class="nav nav-treeview <?= $isActive ? 'in' : '' ?>">
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
                <li class="nav-item">
                    <?php
                    echo Html::beginForm(['/site/logout'], 'post');
                    echo Html::submitButton(
                        '<i class="fa fa-fw fa-power-off"></i> Выход',
                        ['class' => 'nav-link ']
                    );
                    echo Html::endForm();
                    ?>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
