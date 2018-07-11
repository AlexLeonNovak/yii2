<?php

use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use kartik\date\DatePicker;
use common\models\User;
use backend\modules\users\models\UsersGroup;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\Test;
use backend\modules\testusers\models\Timestamp;

$arrayFilterThemeAndTest['Тесты'] = ArrayHelper::map(Test::find()->all(), 'id', 'name');
$arrayFilterThemeAndTest['Темы'] = ArrayHelper::map(Themes::find()->all(), 'id', 'name');

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\testusers\models\TimestampSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\testusers\models\Timestamp */
$this->title = 'Статистика';
$this->params['breadcrumbs'][] = ['label' => 'Список тем тестов', 'url' => ['/testusers']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1><?= Html::encode($this->title); ?></h1>
<?= GridView::widget([
    'dataProvider'  => $dataProvider,
    'filterModel'   => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        
        [
            'attribute' => 'id_user',
            'value' => 'user.fullNameInitials',
            'filter' => Html::activeDropDownList($searchModel,
                        'id_user',
                        ArrayHelper::map(User::find()->all(), 'id', 'fullNameInitials'),
                        ['class' => 'form-control','prompt' => 'Все']
                        ),
            'label' => 'Сотрудник',
        ],
        [
            'attribute' => 'id_group',
            'value' => 'usersGroup.name',
            'filter' => Html::activeDropDownList($searchModel,
                        'id_group',
                        ArrayHelper::map(UsersGroup::find()->all(), 'id', 'name'),
                        ['class' => 'form-control','prompt' => 'Все']
                        ),
            'label' => 'Должность',
        ],
        [
            'attribute' => 'timestamp',
            'format' => ['Datetime', 'php:d.m.Y H:i:s'],
            'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                ]),
        ],
        [
            'attribute' => 'themeOrTest.name',
            'value' => function ($model){
                return $model->for ? 'Тема: ' . $model->themeOrTest->name : 'Тест: ' . $model->themeOrTest->name;
            },
            'label' => 'Тема/Тест',
//            'filter' => function ($model) use ($searchModel, $arrayFilterThemeAndTest){
//                        return Html::activeDropDownList($searchModel,
//                        'for_tt',
//                        ArrayHelper::map($model->getThemeOrTest()->all(), 'id', 'name' , $model->for),
//                        $arrayFilterThemeAndTest,
//                        //[0 => 'Тест', 1 => 'Тема'],
//                        ['class' => 'form-control','prompt' => 'Все']
//                        );
//            },
        ],
//        [
//            'attribute' => 'themeOrTest.name',
//        ],
        [
            'label' => 'Ответы (П/Н/%)',
            'format' => 'html',
            'value' => function ($model){
                $percent = count($model->userAnswers) ? round($model->answersCorrectCount/count($model->userAnswers)*100) : 0;
                return '<span class="text-success">' . $model->answersCorrectCount . '</span> / '
                       .'<span class="text-danger">' . (count($model->userAnswers) - $model->answersCorrectCount) . '</span> / '
                       .'<b>' .  $percent . '%</b>' ;
            },
            'headerOptions' => [
                'class' => 'col-sm-2',
                'title' => 'Правильные / Неправильные / Прогресс',
            ],
            'contentOptions' => [
                'title' => 'Правильные / Неправильные / Прогресс',
            ]
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header'=> 'Действия',
            'template' => '{view} {delete}',
        ],
    ]
]);
