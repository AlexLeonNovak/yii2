<?php

/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */
use yii\grid\GridView;
use yii\bootstrap\Html;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $model backend\modules\zadarma\models\Zadarma */
/* @var $this yii\web\View */

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
            'call_start',
            'answer_time',
            'call_end',
            'internal',
            'destination',
            'disposition',
            'duration',
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
