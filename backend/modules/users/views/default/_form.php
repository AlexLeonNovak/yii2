<?php

use yii\bootstrap\ActiveForm;
use yii\jui\AutoComplete;
use yii\bootstrap\Html;
use backend\modules\users\UsersAsset;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $modelActions backend\modules\users\models\AuthActions */
/* @var $modelControllers backend\modules\users\models\AuthControllers */
/* @var $modelModules backend\modules\users\models\AuthModules */

UsersAsset::register($this);


?>

<div class="users-default-directory_form">
    <?php
    $form = ActiveForm::begin();
    ?>
    <div class="row">
        <div class="col-sm-4">
            <?= Html::activeHiddenInput($modelModules, 'id'); ?>
            <?=
            $form->field($modelModules, 'name')->widget(AutoComplete::classname(), [
                'clientOptions' => [
                    'source' => $modelModules->find()
                            ->select(['name as label', 'id', 'description'])
                            ->asArray()->all(),
                    'select' => new JsExpression("function( event, ui ) {
			        $('#authmodules-id').val(ui.item.id);
                                $('#authmodules-description').val(ui.item.description);
                                $('#authmodules-name').prop('readonly', true);
                                $('#authmodules-description').prop('readonly', true);
                                $('#authcontrollers-id_module').val(ui.item.id);
                                var id_module = (ui.item.id);
                                $('#authcontrollers-name').autocomplete({
                                    source: 'list?id_module='+id_module
                                }).focus();
			     }"),
                ],
                'options' => [
                    'class' => 'form-control',
                    'readonly' => $isUpdate,
                ],
                
            ]);
            ?>
        </div>
        <div class="col-sm-8">
            <?= $form->field($modelModules, 'description')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= Html::activeHiddenInput($modelControllers, 'id'); ?>
            <?= Html::activeHiddenInput($modelControllers, 'id_module'); ?>
            <?=
            $form->field($modelControllers, 'name')->widget(AutoComplete::classname(), [
                'clientOptions' => [
                    'select' => new JsExpression("function( event, ui ) {
			        $('#authcontrollers-id').val(ui.item.id);
                                $('#authcontrollers-description').val(ui.item.description);
                                $('#authcontrollers-name').prop('readonly', true);
                                $('#authcontrollers-description').prop('readonly', true);
                                $('#authactions-id_controller').val(ui.item.id);
                                var id_controller = (ui.item.id);
                                $('#authactions-name').autocomplete({
                                    source: 'list?id_controller='+id_controller
                                }).focus();
			     }"),
                ],
                'options' => [
                    'class' => 'form-control',
                    'readonly' => $isUpdate,
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-8">
            <?= $form->field($modelControllers, 'description')->textInput() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= Html::activeHiddenInput($modelActions, 'id'); ?>
            <?= Html::activeHiddenInput($modelActions, 'id_controller'); ?>
            <?=
            $form->field($modelActions, 'name')->widget(AutoComplete::classname(), [
                'clientOptions' => [
                    'select' => new JsExpression("function( event, ui ) {
			        $('#authactions-id').val(ui.item.id);
                                $('#authactions-description').val(ui.item.description);
                                $('button[type=\"submit\"]').focus();
			     }"),
                ],
                'options' => [
                    'class' => 'form-control',
                    'readonly' => $isUpdate,
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-8">
            <?= $form->field($modelActions, 'description')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>