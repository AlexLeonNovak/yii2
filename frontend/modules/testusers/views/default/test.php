<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = $test_name;
?>

<h1><?=$this->title; ?></h1>

<div class="panel panel-default">
    <div class="panel-heading"><?=$question->question; ?></div>
    <div class="list-group">
        <?php $form = ActiveForm::begin(); ?>
        <?php foreach ($answers as $answer){ 
           echo Html::submitButton($answer->answer, [
                    'class' => 'list-group-item',
                    'value' => $answer->id,
                    'name'  => 'id_answer',
                ]);
        } ?>
        <?php ActiveForm::end() ?>
    </div>
</div>

