<?php

namespace app\modules\testusers\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\Test;
use backend\modules\testusers\models\ThemesSearch;
use backend\modules\testusers\models\Questions;
use backend\modules\testusers\models\Answers;
use backend\modules\testusers\models\UserAswer;
use backend\modules\testusers\models\Timestamp;
use common\models\User;
use yii\db\Expression;
use yii\data\ArrayDataProvider;


/**
 * Default controller for the `testusers` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->session->remove('questions');
        Yii::$app->session->remove('ids_answer');
        Yii::$app->session->remove('timestamp');
        $searchModel = new ThemesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $user_group = User::getUserGroup();
        $themes = Themes::findAll(['id_group' => $user_group]);
        //$themes = Themes::find()->all();
        foreach ($themes as $theme){
            $themes_ids[] = $theme->id;
        }
        //var_dump($themes_ids);
        $tests = Test::findAll(['id_theme' => $themes_ids]);
        //var_dump($tests);
        $dataProvider->query->andWhere('id_group = '. $user_group);
        
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => $themes,
            'tests' => $tests,
        ]);
    }
    
    public function actionTest($id_test)
    {
        $ids_answer = [];       //массив с ид ответами, на которые пользователь ответил
        $not_in = [];           //массив для условия выборки
        $questions_showed = []; //массив с ид вопросами, которые были показаны
        if (!Yii::$app->session['timestamp']){
            Yii::$app->session['timestamp'] = time();
        }
        if (Yii::$app->session['questions']){
            $questions_showed = Yii::$app->session['questions'];
            $not_in = ['not in', 'id', Yii::$app->session['questions']];
            $ids_answer = Yii::$app->session['ids_answer'];
            if(Yii::$app->getRequest()->post('id_answer')){ //получаем ид ответа, который пользователь выбрал
                $ids_answer[] = Yii::$app->getRequest()->post('id_answer'); //записываем в масив
            } else {
                $ids_answer[] = 0;  //если таймер обновил страницу, то пользователь ничего не выбрал
            }
            Yii::$app->session['ids_answer'] = $ids_answer; //записываем в сессию ответы
        }
        $question = Questions::find()->Where(['id_test' => $id_test])
                ->andFilterWhere($not_in)
                ->orderBy(new Expression('rand()'))->one();            
           
        if (!$question){
            $timestamp = new Timestamp;
            $timestamp->id_test = $id_test;
            $timestamp->timestamp = Yii::$app->session['timestamp'];
            $timestamp->save();
            $count = Questions::find(['id_test' => $id_test])->count(); //получаем количество вопросов
            for ($i = 0; $i < $count; $i++){ //перебираем все вопросы и записываем в БД
                $user_answer = new UserAswer; 
                $user_answer->id_answer = Yii::$app->session['ids_answer'][$i];
                $user_answer->id_question = Yii::$app->session['questions'][$i];
                $user_answer->id_user = Yii::$app->user->identity->id;
                $user_answer->id_timestamp = $timestamp->id;
                $user_answer->save();
            }
            Yii::$app->session->remove('questions');
            Yii::$app->session->remove('ids_answer');
            Yii::$app->session->remove('timestamp');
            return $this->actionResult($id_test, $timestamp->id); //отправляем на страницу результатов
        }
        $questions_showed[] = $question->id; //записываем в массив показаные вопросы
        Yii::$app->session['questions'] = $questions_showed; //запмсь в сессию этот массив (по другому почему-то не работает...)
        $answers = Answers::findAll(['id_question' => $question->id]);
        $test_name = Test::findOne(['id' => $id_test])->name;
        return $this->render('test',[
            'question'  => $question,
            'answers'   => $answers,
            'test_name' => $test_name,
        ]);
    }
    
    public function actionResult($id_test, $id_timestamp = null)
    {
        $timestamp = Timestamp::find()->where(['id_test' => $id_test]);
        if($id_timestamp){
            $timestamp->andWhere(['id' => $id_timestamp]);
        } 
        $times = $timestamp->all();
        $provider = [];
        $date = [];
        foreach ($times as $time){
            $user_answers = UserAswer::findAll([
                        'id_user' => Yii::$app->user->identity->id,
                        'id_timestamp' => $time->id,
                    ]);
            $date[] = 
            $result = [];
            foreach ($user_answers as $user_answer){
                $question = Questions::findOne([
                            'id' => $user_answer->id_question,
                            'id_test' => $id_test,
                        ]);
                $answer = Answers::findOne(['id' => $user_answer->id_answer]);
                $result[] = [
                    'question'      => $question->question,
                    'answer'        => $answer->answer,
                    'is_correct'    => $answer->correct,
                ];
            }
            $provider[] = new ArrayDataProvider([
                    'allModels' => $result,
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
        }
           // var_dump($result);
        return $this->render('result',[
            'result'    => $result,
            'provider'  => $provider,
        ]);
    }
    
}
