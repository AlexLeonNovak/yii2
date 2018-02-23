<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\users\models\UsersGroup;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\testusers\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список тем тестов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать тему', ['create'],['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'name',
            //'id',
            //'id_group',
            'group_name' => [
                'attribute' => 'id_group',
                'format'=>'text',
                'value' => function($model){
                    return $model->group->name;
                },
                'filter' => Html::activeDropDownList($searchModel,
                        'id_group',
                        ArrayHelper::map(UsersGroup::find()->all(), 'id', 'name'),
                        ['class' => 'form-control','prompt' => 'Все']
                        ),
            ],

            ['class' => 'yii\grid\ActionColumn',
                'header'=> 'Действия',
                'template' => '{view} {update} {delete} {addtest}',
                'buttons' => [
                    'view' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                Url::to(['test/index', 'id_theme' => $model->id]),
                                ['title' => 'Просмотр тестов']
                                );
                    },
                    'addtest' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>',
                                Url::to(['test/create', 'id_theme' => $model->id]),
                                ['title' => 'Добавить тест']
                                );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
