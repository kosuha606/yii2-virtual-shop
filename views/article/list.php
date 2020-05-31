<?php

use app\virtualModels\Domains\Article\Models\ArticleVm;
use yii\helpers\Html;

/** @var ArticleVm[] $articles */

?>

<?php foreach ($articles as $article) { ?>
    <div>
        <h3>
            <?= Html::a($article->langAttribute('title'), ['article/detail', 'id' => $article->id, 'slug' => $article->slug]) ?>
        </h3>
        <?= $article->created_at ?>
        <hr>
    </div>
<?php } ?>
