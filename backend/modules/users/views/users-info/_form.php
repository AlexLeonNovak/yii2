<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\users\models\UsersInfo */
/* @var $form yii\widgets\ActiveForm */

// Массив для выбора типа информации
$data = array_unique(ArrayHelper::merge($model->find()->select('type')->groupBy('type')->column(), 
        ['Задачи', 'Резюме', 'Увлечения', 'Комментарий']));
sort($data); //Сортировка
$data = array_combine($data, $data); // Заполнение массива ключ => значение, где ключ = значение
?>

<div class="users-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <h3><?= $model->user->fullName; ?></h3>
    <hr>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
            'data' => $data,
            'options' => ['placeholder' => 'Выберете тип информации или введите новый'],
            'pluginOptions' => [
                'maximumInputLength' => 20,
            ],
        ])->hint('Если хотите добавить новый тип информации, то напишите и нажмите клавишу "Enter"'); ?>
    <?= $form->field($model, 'value')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
