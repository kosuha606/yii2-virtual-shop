<?php

/** @var ArticleVm $article */

use app\virtualModels\Domains\Article\Models\ArticleVm;

?>

<h1><?= $article->title ?></h1>

<div>
    <?= $article->content ?>
</div>