<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use frontend\modules\testusers\TestAsset;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $answers[] \backend\modules\testusers\models\Answers */
/* @var $question \backend\modules\testusers\models\Questions */
/* @var $timer integer */

TestAsset::register($this);
$this->title = $test_name;
?>

<h1><?=$this->title; ?></h1>
<?php Pjax::begin(); ?>
<div id="loader"></div>
<div class="row" style="text-align:right;margin:5px;">Вопрос <b><?=Yii::$app->session['item_question']; ?></b> из <b><?=Yii::$app->session['count_questions']; ?></b></div>
<div class="row">
    <div class="col-sm-1">
        <span class="timer">00:00</span>
    </div>
    <div class="col-sm-11">
        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
            <span class="sr-only"></span>
          </div>
        </div>
    </div>
</div>
<?php $form = ActiveForm::begin(); ?>
<div class="panel panel-default">
    <div class="panel-heading"><?=$question->question; ?></div>
        <?php //foreach ($answers as $answer){ 
           // echo Html::listBox($name);
//           echo Html::submitButton($answer->answer, [
//                    'class' => 'list-group-item',
//                    'value' => $answer->id,
//                    'name'  => 'id_answer',
//                ]);
        //} 
        ?>
        
        <?= Html::checkboxList('answer', null, ArrayHelper::map($answers, 'id', 'answer'),[
            'class' => 'list-group',
            'item' => function ($index, $label, $name, $checked, $value){
                    return Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => $label,
                        //'label' => '<i class="fa fa-check glyphicon glyphicon-ok"></i>' . $label,
                        'labelOptions' => [
                            'class' => 'list-group-item btn btn-default',
                           ]
                    ]);
            },
        ]); ?>
</div>
<div class="align-center">
<?= Html::submitButton('Ответить',['class' => 'btn btn-lg btn-primary col-xs-12']) ?>
</div>
<?php ActiveForm::end() ?>
<?php Pjax::end(); ?>
<?php 

$this->registerJs('var timer = ' . $timer . ';',  $this::POS_HEAD);
$css = <<< CSS
        .list-group-item{
            text-align: left!important;
            white-space: normal;
        }
CSS;
$this->registerCss($css);