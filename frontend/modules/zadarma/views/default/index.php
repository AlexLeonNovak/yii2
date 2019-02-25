<?php

use yii\grid\GridView;
use yii\bootstrap\Html;
use backend\modules\zadarma\models\Zadarma;
use kartik\date\DatePicker;

/* @var $model backend\modules\zadarma\models\Zadarma */
/* @var $this yii\web\View */

$this->title = 'Журнал звонков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zadarma-default-index">
    <h1><?= $this->title ?></h1>
    <?php if (!isset($dataProvider)){ ?>
    <div class="alert alert-danger">Ув. <?= Yii::$app->user->identity->fullName ?>, Вам не подключен номер от компании Zadarma. 
        В случае необходимости, обратитесь пожалуйста к Руководству.<br>Благодарим, администрация.</div>
    <?php } else { ?>
    <audio controls>
        Ваш браузер не поддерживает <code>audio</code> элемент.
    </audio>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if($model->disposition == 'разговор'){
                return ['class' => 'success'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'type',
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
                            . ' <span class="text-success"><strong>(' 
                            . date("i:s", $model->answer_time - $model->call_start) 
                            . ' c.)</strong></span>';
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'call_start_date',
                ]),
            ],
            [
                'attribute' => 'answer_time',
                'format' => ['Datetime', 'php:d.m.Y H:i:s'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'answer_time_date',
                ]),
            ],
            [
                'attribute' => 'call_end',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->call_end, 'php:d.m.Y H:i:s')
                            . ' <span class="text-success"><strong>(' 
                            . date("i:s", $model->call_end - $model->answer_time) 
                            . ')</strong></span>';
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'call_end_date',
                ]),
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
                                    'data-seconds' => $model->call_end - $model->answer_time
                        ]);
                    }
                    return 'Нет записи';
                },
                'filter' => [
                    0 => 'Нет записи',
                    1 => 'Есть запись',
                ],
                'headerOptions' => [
                    'title' => 'Нажав на кнопку Play Вы можете прослушать звукозапись разговора',
                ],
                'contentOptions' => [
                    'title' => 'Нажав на кнопку Play Вы можете прослушать звукозапись разговора',
                ]
            ],
        ],
    ]);
    } ?>
</div>
<?php
$js = <<< JS
        $('.record').click(function(){
            var call_id = $(this).attr('data-call-id');
            var seconds = $(this).attr('data-seconds');
                $.ajax({
                    url: '/admin/zadarma/default/get-record',
                    type: 'POST',
                    cache: false,
                    data: {call_id:call_id,seconds:seconds},
                    success: function (data) {
                        $('audio').attr('src', data);
                        $('audio').trigger('play');
                    }
                });
        });
JS;
$this->registerJs($js);
