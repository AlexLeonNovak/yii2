<?php

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;

$this->title = $test_name;
?>

<h1><?=$this->title; ?></h1>
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

<?php 
$timer = Yii::$app->session['timer'] ? Yii::$app->session['timer'] : 60;
$script = <<< JS
    var i = 10 * $timer; // Вместо цифры 60 можно указать переменную (в секундах)
    var t = i;
    var counterBack = setInterval(function(){
      i--;
      if (i >= 0){
        $('.progress-bar').css('width', 100*i/t + '%');
        if (100*i/t <10) {
            $('.progress-bar').addClass('progress-bar-danger').removeClass('progress-bar-warning');
            $('.timer').addClass('text-danger');
        } else if (100*i/t <30) {
            $('.progress-bar').addClass('progress-bar-warning');
        }
        m = Math.floor(i/10/60) ^ 0;
        s = (i/10 % 60) ^ 0;
        $('.timer').text((m<10?"0"+m:m) + ':' + (s<10?"0"+s:s));
      } else {
        clearInterval(counterBack);
        $('button[type="submit"]').val('0').submit();
        //location.reload(true);
      }
    }, 100);
        
JS;

$this->registerJs($script);
        
?>
