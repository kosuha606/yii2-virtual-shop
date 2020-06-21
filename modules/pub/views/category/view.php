<?php

use app\widgets\ProductsWidget;
use kosuha606\VirtualShop\Model\CategoryVm;

/** @var CategoryVm $category */

?>

<div>
    <div class="body-content">
        <?= ProductsWidget::widget(['categoryId' => $category->id]); ?>
    </div>
</div>