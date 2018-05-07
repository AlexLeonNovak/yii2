<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\testusers\models\TestMsg */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Настройки сообщений';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="test-msg-index">

    <div class="test-msg-form">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'msgWarning')->textInput() ?>

        <?= $form->field($model, 'msgViolation')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
