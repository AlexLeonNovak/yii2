<?php 

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
/* @var $model backend\modules\users\models\AuthActions */

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Разрешить доступ к действию: <?= $model->getModuleControllerAction() ?>
        </div>
        <?php ActiveForm::begin(); ?>
        <div class="modal-body">
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

