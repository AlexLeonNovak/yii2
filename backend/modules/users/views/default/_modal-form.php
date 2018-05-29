<?php 

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
/* @var $model backend\modules\users\models\AuthActions */
print_r($ids_user);
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Разрешить доступ к 
            <?php 
            switch ($module['auth']) {
                case 'action': echo 'действию: ' . $module['name']; break;
                case 'controller': echo 'контроллеру: ' . $module['name']; break;
                case 'module': echo 'модулю: ' . $module['name']; break;
            }
            ?>
        </div>
        <?php ActiveForm::begin(); ?>
        <div class="modal-body">
            <?php if ($module['auth'] != 'action') { ?>
            <div class="alert alert-warning"><span class="glyphicon glyphicon-warning-sign"></span> 
                <strong>В этом списке не отображаются доступы которые есть у сотрудников</strong>
                <br><span>При выборе сотрудников доступ будет обновлен для всех действий<br>Будьте внимательны!</span>
            </div>
            <?php } ?>
            <?= Html::checkboxList('ids', $ids_user, $user_list); ?>
        </div>
        <div class="modal-footer">
            <?= Html::button('Закрыть', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
            <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-success']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php

