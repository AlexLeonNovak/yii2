<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\users\models\UsersGroup;

/* @var $this yii\web\View */
/* @var $model backend\modules\testusers\models\TestSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_group')->dropDownList(ArrayHelper::map(UsersGroup::find()->select(['name', 'id'])->groupBy('id')->all(), 'id', 'name')) ?>

    <?= $form->field($model, 'timer')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
