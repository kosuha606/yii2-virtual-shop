<?php

/** @var ArticleVm $article */

use app\virtualModels\Domains\Article\Models\ArticleVm;

?>

<h1><?= $article->title ?></h1>

<div>
    <?= $article->created_at ?>
    <hr>
</div>

<div>
    <?= $article->content ?>
</div>