<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\field\FieldRange;
use kartik\time\TimePicker;

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
        //'enableAjaxValidation' => true,
        'options' => ['data' => ['pjax' => true]],
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
                'type' => FieldRange::INPUT_WIDGET,
                'widgetClass' => TimePicker::className(),
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
                'widgetContainer'=>['class'=>'col-sm-9'],
                'errorContainer'=>['class'=>'col-sm-offset-3 col-sm-9'],
                //'template' => '{label}<div> {widget}</div></div></div></div>{error}',
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

<?php
$js = <<<JS
        $('#user-worktime_start, #user-worktime_end').change(function() {
            var start = $('#user-worktime_start').val().split(':');
            var end = $('#user-worktime_end').val().split(':');
            var startTimeObject = new Date();
            startTimeObject.setHours(start[0], start[1], 0);
            var endTimeObject = new Date();
            endTimeObject.setHours(end[0], end[1], 0);
            var controlTime = new Date();
            controlTime.setHours(9, 0, 0);
            if (startTimeObject > endTimeObject) {
                $('.field-user-worktime_start, .field-user-worktime_end, #user-worktime_start-error').addClass('has-error').removeClass('has-success has-warning');
                $('#user-worktime_start-error .help-block').text('Время конца рабочего времени не должно быть больше начала');
            } else if (startTimeObject < controlTime || endTimeObject < controlTime) {
                $('.field-user-worktime_start, .field-user-worktime_end, #user-worktime_start-error').addClass('has-warning').removeClass('has-success has-error');
                $('#user-worktime_start-error .help-block').text('Время рабочего времени меньше 09:00');
            } else {
                $('.field-user-worktime_start, .field-user-worktime_end, #user-worktime_start-error').addClass('has-success').removeClass('has-error has-warning');
                $('#user-worktime_start-error .help-block').text('');
            }
        });
        
JS;
$this->registerJs($js);
