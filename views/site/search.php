<?php


use app\virtualProviders\ZendLuceneSearch\ZendLuceneSearchProvider;
use kosuha606\VirtualAdmin\Domains\Search\SearchVm;
use kosuha606\VirtualModel\VirtualModelManager;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var ZendLuceneSearchProvider $provider */
$provider = VirtualModelManager::getInstance()->getProvider(SearchVm::KEY);

?>

<h1>Поиск</h1>

<?php

$form = ActiveForm::begin(['method' => 'get', 'action' => '/site/search']);

$q = Yii::$app->request->get('q', '');

$results = $provider->search($this, $q);

?>


<div class="row">
    <div class="col-md-8">
        <input name="q" value="<?= $q ?>" type="text" class="form-control">
    </div>
    <div class="col-md-4">
        <button class="btn btn-primary">Найти</button>
    </div>
</div>

<?php

ActiveForm::end();

?>

<p>&nbsp;</p>

<?php
if (isset($results['results'])) {
    foreach ($results['results'] as $result) { ?>
        <div>
            <b><?= Html::a($result->title, $result->url) ?></b>
            <hr>
        </div>
    <?php } ?>
<?php } ?>
