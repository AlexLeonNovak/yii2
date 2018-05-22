<?php

/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */
use yii\grid\GridView;
use yii\bootstrap\Html;

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
                }
            ],
            'destination',
            'caller_id',
            'disposition',
            //'duration',
            [
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
                }
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
                    url: 'get-record',
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
