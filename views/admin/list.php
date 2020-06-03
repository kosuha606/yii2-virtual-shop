<?php

/** @var $h1 */
/** @var $ad_url */

$ad_url = $ad_url ?? null;

?>

<h1><?= $h1 ?></h1>

<?php if ($ad_url) { ?>
    <a class="btn btn-primary" href="<?= $ad_url ?>">
        <i class="fa fa-plus"></i>
        Добавить
    </a>
<?php } ?>

<list
        :default-sort="_admin.defaultSort"
        id="list"
        :entity-url="'/admin/'+_admin.entity"
        :cell-components="_admin.list_config"
        :filter-components="_admin.filter_config"
>
</list>
