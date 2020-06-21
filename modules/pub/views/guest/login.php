<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Вход';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>


    <?php $form = ActiveForm::begin(
        [
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]
    ); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox(
        [
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]
    ) ?>


    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <a href="<?= Url::toRoute(['guest/restore-password']) ?>">Забыли пароль?</a>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <a class="btn btn-success" href="<?= Url::toRoute(['guest/register']) ?>">
                Регистрация
            </a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
