<?php


$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = [
    'url' => ['guest/login'],
    'label' => 'Вход',
];
$this->params['breadcrumbs'][] = $this->title;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url; ?>


<h1><?= Html::encode($this->title) ?></h1>


<?php $form = ActiveForm::begin(
    [
        'id' => 'restore-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]
); ?>

<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>



    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>