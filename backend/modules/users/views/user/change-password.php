<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model common\models\User */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Изменение пароля сотрудника';
$this->params['breadcrumbs'][] = ['label' => 'Сотрудники', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' ' . $model->fullNameInitials;
?>
<div class="user-change-password">
    <h1><?= Html::encode($this->title) . ' ' . $model->fullName; ?></h1>

    <p>Пожалуйста, заполните следующие поля для смены пароля:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'password_repeat')->passwordInput() ?>
            
                <div class="form-group">
                    <?= Html::submitButton('Изменить пароль', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
