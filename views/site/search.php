<?php


use app\virtualModels\Admin\Domains\Search\SearchVm;
use app\virtualProviders\ZendLuceneSearch\ZendLuceneSearchProvider;
use kosuha606\VirtualModel\VirtualModelManager;
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

<h3>В индексе <?= $provider->zendService->getIndex()->numDocs() ?></h3>

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
foreach ($results['results'] as $result) { ?>
    <div>
        <b><?= $result->title ?></b>
        <hr>
    </div>
<?php } ?>
