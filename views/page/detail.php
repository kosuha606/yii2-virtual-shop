<?php

/** @var PageVm $page */


use kosuha606\VirtualContent\Domains\Page\Models\PageVm;
?>

<h1><?= $page->langAttribute('title') ?></h1>

<div>
    <?= $page->langAttribute('content') ?>
</div>