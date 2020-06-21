<?php

/** @var View $this */
/** @var FavoriteVm[] $favorites */

use kosuha606\VirtualShop\Model\FavoriteVm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm; ?>

<h1>Избранное</h1>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <?php if (!$favorites) { ?>
            <b>Нету в избранном продуктов</b>
        <?php } ?>

        <table class="table table-striped table-bordered">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Название
                </th>
                <th>
                    Цена
                </th>
                <th>

                </th>
            </tr>
            <?php foreach ($favorites as $favorite) { ?>
                <tr>
                    <td class="text-nowrap" width="1%">
                        №
                        <?= $favorite->product_id ?>
                    </td>
                    <td>
                        <?= $favorite->product['name'] ?>
                    </td>
                    <td>
                        <?= $favorite->product['price'] ?>
                    </td>
                    <td width="1%">
                        <?php $form = ActiveForm::begin(['action' => Url::toRoute('/cabinet/delete-favorite'), 'method' => 'post']); ?>

                        <input type="hidden" name="product_id" value="<?= $favorite->product_id ?>">
                        <button class="btn btn-default">Удалить</button>

                        <?php ActiveForm::end(); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>