<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use unclead\multipleinput\MultipleInput;


/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Answers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="answers-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => true,
        'validateOnChange'          => true,
        'validateOnSubmit'          => true,
        'validateOnBlur'            => false,
    ]); ?>

    <?= $form->field($model, 'answers_form')->widget(MultipleInput::className(), [
        //'form' => $form,
        'min' => 2,
        //'id' => 'answers',
        //'allowEmptyList' => true,
//        'attributeOptions' => [
//            'enableAjaxValidation'      => true,
//            'enableClientValidation'    => true,
//            'validateOnChange'          => true,
//            'validateOnSubmit'          => true,
//            'validateOnBlur'            => false,
//        ],
        'columns' => [
            [
                'name' => 'answer',
                'enableError' => true,
                
            ],
            [
                'name' => 'correct',
                'type' => 'Checkbox',
            ]
        ]
    ])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

