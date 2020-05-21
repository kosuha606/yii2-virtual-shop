<?php

/** @var MenuVm $menu */

use app\virtualModels\Domains\Menu\Models\MenuVm;

?>

<div class="menu">
    |
    <?php foreach ($menu->getItems() as $item) { ?>
        <a href="<?= $item->link ?>">
            <?= $item->label ?>
        </a>
        |
    <?php } ?>
</div>
