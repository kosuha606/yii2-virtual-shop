<?php

/** @var ArticleVm $article */

use kosuha606\VritualContent\Domains\Article\Models\ArticleVm;

?>

<h1><?= $article->langAttribute('title') ?></h1>

<div>
    <?= $article->created_at ?>
    <hr>
</div>

<div>
    <?= $article->langAttribute('content') ?>
</div>