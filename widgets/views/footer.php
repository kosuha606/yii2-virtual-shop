<?php

/** @var $menus */

use app\virtualModels\Domains\Menu\Widgets\MenuWidget; ?>

<footer class="footer">
    <div class="container">
        <?php foreach ($menus as $menu) { ?>
            <?= MenuWidget::widget(['code' => $menu]) ?>
            <p>&nbsp;</p>
        <?php } ?>
    </div>
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