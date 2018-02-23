<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Answers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_question')->textInput() ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'correct')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
