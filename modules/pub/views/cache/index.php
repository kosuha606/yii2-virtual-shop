<?php

use kosuha606\VirtualAdmin\Domains\Cache\CacheService;
use kosuha606\VirtualModelHelppack\ServiceManager;

$cacheService = ServiceManager::getInstance()->get(CacheService::class);
$productsCache = $cacheService->many('product', [
    'where' => [['>', 'comments_qty', 0]]
]);

?>
cache


<h3>Продукты с комментариями больше 0</h3>
<table class="table">
    <tr>
        <th>
            Название
        </th>
        <th>
            Остатки
        </th>
        <th>
            Кол-во комментариев
        </th>
    </tr>
    <?php foreach ($productsCache as $cache) { ?>
    <tr>
        <td>
            <?= $cache->name ?>
        </td>
        <td>
            <?= $cache->rests ?>
        </td>
        <td>
            <?= $cache->comments_qty ?>
        </td>
    </tr>
    <?php } ?>
</table>

<?php


$cacheService = ServiceManager::getInstance()->get(CacheService::class);
$productsCache = $cacheService->many('product', [
    'orderBy' => ['rests' => SORT_ASC]
]);

?>

<h3>Продукты с остатками, отсортированными по возрастанию</h3>
<table class="table">
    <tr>
        <th>
            Название
        </th>
        <th>
            Остатки
        </th>
        <th>
            Кол-во комментариев
        </th>
    </tr>
    <?php foreach ($productsCache as $cache) { ?>
        <tr>
            <td>
                <?= $cache->name ?>
            </td>
            <td>
                <?= $cache->rests ?>
            </td>
            <td>
                <?= $cache->comments_qty ?>
            </td>
        </tr>
    <?php } ?>
</table>