
<?php

/** @var MenuVm $menu */

use kosuha606\VirtualAdmin\Domains\Menu\MenuVm;


?>



<div class="menu">
    <?php foreach ($menu->getItems() as $item) { ?>
        <a href="<?= $item->link ?>">
            <?= $item->langAttribute('label') ?>
        </a>
    <?php } ?>
</div>