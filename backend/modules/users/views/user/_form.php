<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\field\FieldRange;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @var $group backend\modules\users\models\UsersGroup */

if (!isset($model->dateOfBirth)){ //установка даты по умолчанию
    $model->dateOfBirth = '1980-01-01';
}
?>

<div class="user-form">

    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
    ]);
    ?>


    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'lastName')->textInput() ?>

            <?= $form->field($model, 'firstName')->textInput() ?>

            <?= $form->field($model, 'middleName')->textInput() ?>

            <?= $form->field($model, 'id_group')->dropDownList(ArrayHelper::map($group, 'id', 'name')) ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'dateOfBirth')->widget(DateControl::classname(), [
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'autoclose' => true,
                    'startDate' => '01.01.1900',
                    'endDate' => '-18y',
                ],
            ]);
            ?>
            
            <?=
            FieldRange::widget([
                'form' => $form,
                'model' => $model,
                'label' => 'Рабочее время',
                'attribute1' => 'worktime_start',
                'attribute2' => 'worktime_end',
                'type' => FieldRange::INPUT_TIME,
                'separator' => '-',
                'widgetOptions1' => [
                    'pluginOptions' => [
                        'showMeridian' => false,
                    ],
                ],
                'widgetOptions2' => [
                    'pluginOptions' => [
                        'showMeridian' => false,
                    ],
                ],
            ]);
            ?>

        <?= $form->field($model, 'status')->dropDownList(['0' => 'Неактивный', '10' => 'Активный']) ?>
        </div>
    </div>

    <div class="form-group">
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
