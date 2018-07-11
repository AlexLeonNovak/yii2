<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use backend\modules\users\models\UsersGroup;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\testusers\models\Themes */
/* @var $form yii\widgets\ActiveForm */
/* @var $groups backend\modules\testusers\models\TestThemesUsersGroup */

$data = ArrayHelper::map(UsersGroup::find()->all(), 'id', 'name');
?>

<div class="themes-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <!--<label class="control-label">Основная группа должности</label>-->
    <?= $form->field($model, 'id_group')->dropDownList($data, ['prompt' => 'Выберете основную группу...']); ?>
    
    <label class="control-label">Дополнительные должности сотрудников</label>
    <?= Select2::widget([
            'value' => ArrayHelper::getColumn($groups, 'id'),
            'name' => 'TestThemesUsersGroup[id_group]',
            'data' => $data,
            'options' => ['placeholder' => 'Выберете должности ...', 'multiple' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
