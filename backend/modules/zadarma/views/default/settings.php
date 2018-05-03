<?php
/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */ 

use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $this yii\web\View */

$this->title = 'Настройки API';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="zadarma-settings">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="alert alert-info">Чтобы получить ключи авторизации перейдите в 
            <?= Html::a('личный кабинет', 'https://my.zadarma.com/api/', ['class' => 'alert-link']); ?> 
            и следуйте инструкциям указаных там <br><br>
            <?= Html::a('Перейти в личный кабинет', 'https://my.zadarma.com/api/', ['class' => 'btn btn-info', 'target'=>'_blank']) ?>
        </div>
                
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'key')->textInput() ?>

        <?= $form->field($model, 'secret')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    

</div>