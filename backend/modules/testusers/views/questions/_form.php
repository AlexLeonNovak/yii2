<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Questions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="questions-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'question')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
