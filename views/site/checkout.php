<?php

use yii\helpers\Url;


$this->params['breadcrumbs'][] = 'Завершение заказа';
?>
<h1>Завершение заказа</h1>


<a class="btn btn-primary" href="<?= Url::toRoute(['site/delivery']) ?>">Завершить заказ</a>
