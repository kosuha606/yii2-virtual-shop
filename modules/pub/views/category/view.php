<?php

use app\virtualModels\Model\CategoryVm;
use app\widgets\ProductsWidget;

/** @var CategoryVm $category */

?>

<div>
    <div class="body-content">
        <?= ProductsWidget::widget(['categoryId' => $category->id]); ?>
    </div>
</div>