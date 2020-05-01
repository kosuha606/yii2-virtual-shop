<?php

/** @var ProductVm $product */

use app\virtualModels\Model\ProductVm;

$this->title = $product->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $product->name ?></h1>

<p>
    Цена: <?= $product->sale_price ?> руб.
</p>
