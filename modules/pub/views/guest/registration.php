<?php


$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = [
    'url' => ['guest/login'],
    'label' => 'Вход',
];
$this->params['breadcrumbs'][] = $this->title;

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<h1><?= Html::encode($this->title) ?></h1>


<?php $form = ActiveForm::begin(
    [
        'id' => 'registration-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]
); ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'repeatPassword')->passwordInput() ?>




    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>