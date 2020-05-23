<?php

use app\virtualModels\Domains\Article\Models\ArticleVm;

/** @var ArticleVm[] $articles */

?>

<?php foreach ($articles as $article) { ?>
    <div>
        <b>
            <?= $article->title ?>
        </b>
        <?= $article->created_at ?>
    </div>
<?php } ?>
