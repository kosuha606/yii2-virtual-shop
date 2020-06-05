<?php

/** @var $h1 */
/** @var VirtualModel $item */
/** @var $entity */

$next = $item::one([
    'where' => [['>', 'id', $item->id]],
    'limit' => 1,
]);
$prev = $item::one([
    'where' => [['<', 'id', $item->id]],
    'limit' => 1,
    'orderBy' => ['id' => SORT_DESC],
]);


use kosuha606\VirtualModel\VirtualModel; ?>

<div>
    <?php if ($prev->id) { ?>
        <a class="btn btn-default" href="/admin/<?= $entity ?>/detail?id=<?= $prev->id ?>">
            <i class="fa fa-arrow-left"></i>
            Предыдущий
        </a>
    <?php } ?>
    <?php if ($next->id) { ?>
        <a class="btn btn-default" href="/admin/<?= $entity ?>/detail?id=<?= $next->id ?>">
            Следующий
            <i class="fa fa-arrow-right"></i>
        </a>
    <?php } ?>
</div>

<hr>

<h1><?= $h1 ?></h1>


<detail
    :id="_admin.model.id"
    :detail-config="_admin.detail_config"
    :save-url="'/admin/'+_admin.entity+'/detail'"
    :item="_admin.model"
    :additional-components="_admin.additional_config"
    :detail-components="_admin.config">

</detail>
