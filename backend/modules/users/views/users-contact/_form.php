<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\UsersContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="users-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3><?= $model->user->lastName ? $model->user->fullNameInitials : $model->user->username; ?></h3>
    <hr>

    <?= $form->field($model, 'type')->widget(AutoComplete::classname(), [
            'clientOptions' => [
                'source' => $model->find()->select('type')->groupBy('type')->column(),
            ],
            'options'=>[
                'class'=>'form-control'
            ]
        ])->hint('Введите первые буквы (Например "Телефон", "Skype" и т.п.)'); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
