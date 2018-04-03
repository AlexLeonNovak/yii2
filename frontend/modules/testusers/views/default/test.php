<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use frontend\modules\testusers\TestAsset;

/* @var $this yii\web\View */
/* @var $answers[] \backend\modules\testusers\models\Answers */
/* @var $question \backend\modules\testusers\models\Questions */

TestAsset::register($this);
$this->title = $test_name;
?>

<h1><?=$this->title; ?></h1>
<?php Pjax::begin(); ?>
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
<?php $this->registerJs('var timer = ' . Yii::$app->session['timer'] . ';',  $this::POS_HEAD); ?>
<?php Pjax::end(); 
