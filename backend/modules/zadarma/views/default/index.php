<?php
/**
 * @author Alex Novak <alexleonnovak@gmail.com>
 */ 

use yii\grid\GridView;
use yii\bootstrap\Html;

/* @var $balance backend\modules\zadarma\components\Zadarma */
/* @var $this yii\web\View */

$this->title = 'Журнал звонков';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="zadarma-default-index">
    <h1><?= $this->title ?></h1>
    <?php if ($balance->status == 'success'){ ?>
    <div class="alert alert-info">Ваш баланс составляет: <strong><?= $balance->balance . ' ' . $balance->currency ?></strong></div>
    <?php } else { ?>
    <div class="alert alert-danger"><strong>Невозможно проверить баланс.</strong>
        Пожалуйста, проверьте <?= Html::a('настройки API', 'settings', ['class' => 'alert-link']); ?></div>
    <?php } ?>
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'event',
            'duration',
//            'caller_id',
//            'called_did',
            'call_start',
            'internal',
            'destination',
            'disposition',
//            'status_code',
//            'is_recorded',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    

</div>
