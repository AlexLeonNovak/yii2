<?php

/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */

use yii\grid\GridView;
use yii\bootstrap\Html;
use backend\modules\zadarma\models\Zadarma;
use kartik\date\DatePicker;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $model backend\modules\zadarma\models\Zadarma */
/* @var $this yii\web\View */
/* @var $usersContactArray array */

$this->title = 'Журнал звонков';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="zadarma-default-index">
    <h1><?= $this->title ?></h1>
    <?php if ($balance->status == 'success') { ?>
        <div class="alert alert-info">
            <div class="row">
                <div class="col-sm-6">
                    Ваш баланс составляет: <strong><?= $balance->balance . ' ' . $balance->currency ?></strong>
                </div>
                <div class="col-sm-6 text-right">
                    <audio controls>
                        Ваш браузер не поддерживает <code>audio</code> элемент.
                    </audio>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="alert alert-danger"><strong>Невозможно проверить баланс.</strong>
            Пожалуйста, проверьте <?= Html::a('настройки API', 'settings', ['class' => 'alert-link']); ?></div>
    <?php } ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if($model->disposition == 'разговор'){
                return ['class' => 'success'];
            }
        },
        'tableOptions' => [
            'class' => 'table table-bordered table-condensed'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    if ($model->type === 'Исходящий') {
                        return 'Исх.';
                    } else {
                        return 'Вход.';
                    }
                },
                'filter' => [
                    'Исходящий' => 'Исходящий',
                    'Входящий' => 'Входящий'
                ]
            ],
            [
                'attribute' => 'call_start',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->call_start, 'php:d.m.Y H:i:s')
                            . '<br><span class="text-success"><strong>(' 
                            . date("i:s", $model->answer_time - $model->call_start)
                            . ')</strong></span>';
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'call_start_date',
                ]),
                'contentOptions' => [
                    'class' => 'col-sm-1',
                ]
            ],
            [
                'attribute' => 'answer_time',
                'format' => ['Datetime', 'php:H:i:s'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'answer_time_date',
                ]),
                'contentOptions' => [
                    'class' => 'col-sm-1',
                ]
            ],
            [
                'attribute' => 'call_end',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->call_end, 'php:H:i:s')
                            . '<br><span class="text-success"><strong>(' 
                            . date("i:s", $model->call_end - $model->answer_time)
                            . ')</strong></span>';
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'call_end_date',
                ]),
                'contentOptions' => [
                    'class' => 'col-sm-1',
                ]
            ],
            [
                'attribute' => 'internal',
                'format' => 'raw',
                'value' => function ($model) use ($usersContactArray){
                    $internals = explode(',', $model->internal);
                    foreach ($internals as $key => $val){
                        if (array_key_exists($val, $usersContactArray)){
                            $internals[$key] = $usersContactArray[$val];
                        }
                    }
                    return implode('<br>', $internals);
                },
                'filter' => $usersContactArray,
                'contentOptions' => [
                    'class' => 'col-sm-2',
                ]
            ],
            'destination',
            'caller_id',
            [
                'attribute' => 'disposition',
                'filter' => Zadarma::find()->select('disposition')
                        ->distinct('disposition')
                        ->orderBy('disposition')
                        ->indexBy('disposition')
                        ->column(),
            ],
            
            //'duration',
            [
                'attribute' => 'is_recorded',
                'label' => 'Запись',
                'format' => 'raw',
                'value' => function($model) {
                    if ($model->is_recorded) {
                        return Html::button('<span class="glyphicon glyphicon-play"></span>', [
                                    'class' => 'btn btn-default record',
                                    'data-call-id' => $model->call_id_with_rec,
                        ]);
                    }
                    return 'Нет записи';
                },
                'filter' => [
                    0 => 'Нет записи',
                    1 => 'Есть запись',
                ],
            ],
        ],
    ]);
    ?>


</div>
<?php
$js = <<< JS
        $('.record').click(function(){
            var call_id = $(this).attr('data-call-id');
                $.ajax({
                    url: '/zadarma/default/get-record',
                    type: 'POST',
                    cache: false,
                    data: {call_id:call_id},
                    success: function (data) {
                        $('audio').attr('src', data);
                        $('audio').trigger('play');
                    }
                });
        });
JS;
$this->registerJs($js);
