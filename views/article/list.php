<?php

use kosuha606\VirtualContent\Domains\Article\Models\ArticleVm;
use yii\helpers\Html;

/** @var ArticleVm[] $articles */

?>

<?php foreach ($articles as $article) { ?>
    <div>
        <h3>
            <?= Html::a($article->langAttribute('title'), $article->getUrl()) ?>
        </h3>
        <?= $article->created_at ?>
        <hr>
    </div>
<?php } ?>
