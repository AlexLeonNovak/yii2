<?php 

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
/* @var $model backend\modules\users\models\AuthActions */
/* @var $this yii\web\View */
?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            Разрешить доступ к 
            <?php 
            switch ($module['auth']) {
                case 'action':      echo 'действию: ' . $module['name'];    break;
                case 'controller':  echo 'контроллеру: ' . $module['name']; break;
                case 'module':      echo 'модулю: ' . $module['name'];      break;
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
            <?= Html::checkbox('check-all', false, ['label' => 'Выбрать все', 'id' => 'check-all']); ?>
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
$js = <<<JS
$('#check-all').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    $('input:checkbox').change(function () {
        if (false === $(this).prop("checked")) {
            $("#check-all").prop('checked', false);
        }
        if ($('input:checkbox:checked').length === $('input:checkbox').length - 1) {
            $("#check-all").prop('checked', true);
        }
    });
JS;
$this->registerJs($js);
