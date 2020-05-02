<?php

/** @var View $this */

use yii\helpers\Html;use yii\web\View; ?>

<h1>Личный кабинет</h1>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <h1>Избранное</h1>
    </div>
</div>