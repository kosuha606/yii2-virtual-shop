<?php

/** @var $component */
/** @var $h1 */

?>

<h1 class="title">
    <span><?= $h1 ?></span>
    <a class="button" href="/admin/order/detail">Добавить</a>
</h1>

<<?= $component ?>
id="list"
:entity-url="'/admin/order'"
:cell-components="_listComponents"
:filter-components="_filterComponents"
></<?= $component ?>>

