<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $group backend\modules\users\models\UsersGroup */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'id_group')->dropDownList(ArrayHelper::map($group, 'id', 'name')) ?>
    
    <?= $form->field($model, 'lastName')->textInput() ?>
    
    <?= $form->field($model, 'firstName')->textInput() ?>
    
    <?= $form->field($model, 'middleName')->textInput() ?>
    
    <?= $form->field($model, 'dateOfBirth')->widget(DateControl::classname(), [
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                    'startDate' => '01.01.1900',
                    'endDate' => '-18y',
                ],
                
        ]); ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
