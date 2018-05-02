<?php
/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */ 

use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use backend\modules\zadarma\ZadarmaAsset;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $this yii\web\View */

ZadarmaAsset::register($this);

?>


<div class="zadarma-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>

    <div>Баланс: <?=$balance->balance . ' ' . $balance->currency ?></div>
        <?php 


        echo '<br>';
        print_r($call); 
        ?>
    <?php Pjax::begin(); ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= Html::input('text', 'from'); ?>
        <?= Html::input('text', 'to'); ?>
        <?= Html::submitButton('Позвонить',['class' => 'btn btn-success']); ?>
    
        <?php ActiveForm::end(); ?>
    <?php Pjax::end(); ?>
    

</div>
