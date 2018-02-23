<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\users\models\UsersGroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Themes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="themes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_group')
            ->dropDownList(ArrayHelper::map(UsersGroup::find()->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
