<?php

/** @var PageVm $page */

use app\virtualModels\Domains\Page\Models\PageVm;

?>

<h1><?= $page->title ?></h1>

<div>
    <?= $page->content ?>
</div>