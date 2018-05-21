<?php

use yii\grid\GridView;

/* @var $model backend\modules\zadarma\models\Zadarma */
/* @var $this yii\web\View */

$this->title = 'Журнал звонков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="zadarma-default-index">
    <h1><?= $this->title ?></h1>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'type',
            [
                'attribute' => 'call_start',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->call_start, 'php:d.m.Y H:i:s')
                            . ' <span class="text-success"><strong>(' 
                            . ($model->answer_time - $model->call_start) 
                            . ' c.)</strong></span>';
                }
            ],
            [
                'attribute' => 'answer_time',
                'format' => ['Datetime', 'php:d.m.Y H:i:s'],

            ],
            [
                'attribute' => 'call_end',
                'format' => 'raw',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->call_end, 'php:d.m.Y H:i:s')
                            . ' <span class="text-success"><strong>(' 
                            . ($model->call_end - $model->answer_time) 
                            . ' c.)</strong></span>';
                }
            ],
            
            
            'internal',
            'destination',
            'caller_id',
            'disposition',
            //'duration',
//            [
//                'label' => 'Запись',
//                'format' => 'raw',
//                'value' => function($model) {
//                    if ($model->is_recorded) {
//                        return Html::button('<span class="glyphicon glyphicon-play"></span>', [
//                                    'class' => 'btn btn-default record',
//                                    'data-call-id' => $model->call_id_with_rec,
//                        ]);
//                    }
//                    return 'Нет записи';
//                }
//            ],
        ],
    ]);
    ?>
</div>
