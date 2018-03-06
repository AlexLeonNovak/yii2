<?php

use yii\grid\GridView;
//var_dump($provider);
$this->title = 'Результаты прохождения теста "' . $test_name .'"';
$this->params['breadcrumbs'][] = Yii::$app->session['breadcrumbs-themes'];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?=$this->title; ?></h1>
<?php foreach($dates as $i => $date){ ?>
  <div class="panel panel-info">
      <div class="panel-heading">Дата и время прохождения теста: <b><?=$date; ?></b></div>
    <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $provider[$i],
        'columns' => [
            'question' =>[
                'attribute' => 'question',
                'label' => 'Вопрос',
                'contentOptions' => [
                    'style' => 'width:50%;'
                ],
            ],
            'answer' => [
                'format' => 'html',
                'attribute' => 'answer',
                'label' => 'Ответ',
                'contentOptions' => function($model) {
                    if ($model['is_correct']){
                        return ['class' => 'list-group-item-success'];
                    } else {
                        return ['class' => 'list-group-item-danger'];
                    }
                }
            ]
        ]
    ]); ?>
    </div>
</div>
<?php } ?>

