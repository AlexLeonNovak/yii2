<?php

namespace frontend\modules\testusers\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\Test;
use backend\modules\testusers\models\ThemesSearch;
use backend\modules\testusers\models\Questions;
use backend\modules\testusers\models\Answers;
use backend\modules\testusers\models\UserAnswer;
use backend\modules\testusers\models\Timestamp;
use backend\modules\testusers\models\TestSettings;
use common\models\User;
use yii\db\Expression;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;


/**
 * Default controller for the `testusers` module
 */
class DefaultController extends Controller
{
    const NOT_ANSWER = null; //Нет ответа на вопрос
    const TEST  = 0; //Пользователь проходил только тест
    const THEME = 1; //Пользователь проходил всю тему со всеми тестами
    const DEFAULT_TIMER = 60; // Время по-умолчанию в с. для показа вопроса если не указано в настройках
    private $ids_answer = [];       //массив с ид ответами, на которые пользователь ответил
    private $questions_showed = []; //массив с ид вопросами, которые были показаны
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->session->destroy();
        $searchModel = new ThemesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $user_group = User::getCurrentUserGroupId();
        if ($timer = TestSettings::find()->where(['id_group' => $user_group])->one()->timer) { 
            Yii::$app->session['timer'] = $timer;
        } else {
            Yii::$app->session['timer'] = self::DEFAULT_TIMER;
        }
        $themes = Themes::findAll(['id_group' => $user_group]);
        foreach ($themes as $theme){
            $themes_ids[] = $theme->id;
        }
        $tests = Test::findAll(['id_theme' => $themes_ids]);
        $dataProvider->query->andWhere('id_group = '. $user_group);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => $themes,
            'tests' => $tests,
        ]);
    }
    
    private function getQuestion($id_test = null, $id_theme = null)
    {
        $question_query = Questions::find();
        if ($id_test != null) {
            $question_query->where(['id_test' => $id_test]);
        } elseif ($id_theme !=null){
            $ids_tests = Test::find()->where(['id_theme' => $id_theme])->asArray()->all();
            $question_query->where(['id_test' => ArrayHelper::getColumn($ids_tests, 'id')]);
        }
        if (Yii::$app->session['questions']){
            $this->questions_showed = Yii::$app->session['questions'];
            $question_query->andFilterWhere(['not in', 'id', Yii::$app->session['questions']]);
            $this->ids_answer = Yii::$app->session['ids_answer'];
            if(Yii::$app->getRequest()->post('id_answer')){ //получаем ид ответа, который пользователь выбрал
                $this->ids_answer[] = Yii::$app->getRequest()->post('id_answer'); //записываем в масив
            } else {
                $this->ids_answer[] = self::NOT_ANSWER;  //если таймер обновил страницу, то пользователь ничего не выбрал
            }
            Yii::$app->session['ids_answer'] = $this->ids_answer; //записываем в сессию ответы
        }
        $question = $question_query->orderBy(new Expression('rand()'))->one();
        if ($question->id == null){return false;}
        $this->questions_showed[] = $question->id; //записываем в массив показаные вопросы
        Yii::$app->session['questions'] = $this->questions_showed; //запмсь в сессию этот массив (по другому почему-то не работает...)
        if (!Yii::$app->session['count_questions']){
            Yii::$app->session['count_questions'] = $question_query->count();
            $item_question = 0;
        }
        $item_question = Yii::$app->session['item_question'];
        $item_question++;
        if (!$question) {
            return false;
        } else {
            Yii::$app->session['item_question'] = $item_question;
            return $question;
        }
    }

    public function saveResult($id_test = null, $id_theme = null, $violation = Timestamp::VIOLATION_FALSE) 
    {
        $timestamp = new Timestamp;
        if ($id_test != null){
            $timestamp->for = self::TEST;
            $timestamp->id_theme_test = $id_test;
        } elseif ($id_theme != null){
            $timestamp->for = self::THEME;
            $timestamp->id_theme_test = $id_theme;
        }
        $this->questions_showed = Yii::$app->session['questions'];
        if ($violation){
            $timestamp->violation = Timestamp::VIOLATION_TRUE;
            $this->questions_showed = Yii::$app->session['questions'];
            array_pop($this->questions_showed);
            Yii::$app->session['questions'] = $this->questions_showed;
        }
        if (Yii::$app->session['totaltime']){
            $timestamp->totaltime = Yii::$app->session['totaltime'];
        }
        $timestamp->timestamp = Yii::$app->session['timestamp'];
        $timestamp->save();

        $count = Yii::$app->session['count_questions']; //получаем количество вопросов
        for ($i = 0; $i < $count; $i++){ //перебираем все вопросы и записываем в БД
            $user_answer = new UserAnswer;
            if (Yii::$app->session['ids_answer'][$i]){
                $user_answer->id_answer = Yii::$app->session['ids_answer'][$i];
                $user_answer->id_question = Yii::$app->session['questions'][$i];
            } else {//Yii::$app->session['ids_questions']
                $this->getQuestion($id_test, $id_theme);
                $user_answer->id_answer = self::NOT_ANSWER;
                $user_answer->id_question = Yii::$app->session['questions'][$i];
            }
            $user_answer->id_user = Yii::$app->user->identity->id;
            $user_answer->id_timestamp = $timestamp->id;
            $user_answer->save();
        }
        Yii::$app->session->destroy();
        return $this->redirect(['result',  //отправляем на страницу результатов
            'id_test' => $id_test,
            'id_theme' => $id_theme,
            'id_timestamp' => $timestamp->id,
        ]);
    }
    public function actionTotal($id_test = null, $id_theme = null) 
    {
        $request = Yii::$app->request;
        if ($request->isAjax){
            if($request->post('out')){
                //return $this->redirect('index');
                $this->saveResult($id_test, $id_theme, Timestamp::VIOLATION_TRUE);
            }
            if(!Yii::$app->session['totaltime']){
                Yii::$app->session['totaltime'] = $request->post('totaltime');
            } else {
                $totaltime = Yii::$app->session['totaltime'] + $request->post('totaltime');
                Yii::$app->session['totaltime'] = $totaltime;
            }
        }
    }
    public function actionTest($id_test = null, $id_theme = null)
    {
        $this->layout = 'testlayout';
        if (!Yii::$app->session['timestamp']){
            Yii::$app->session['timestamp'] = time();
        }
        $question = $this->getQuestion($id_test, $id_theme);
        if (!$question){
            $this->saveResult($id_test, $id_theme);
        }
        
        $answers = Answers::findAll(['id_question' => $question->id]);
        if ($id_test != null) {
            $test_name = Test::findOne(['id' => $id_test])->name;
        } elseif ($id_theme !=null){
            $test_name = Themes::findOne(['id' => $id_theme])->name;
        }
        return $this->render('test',[
            'question'  => $question,
            'answers'   => $answers,
            'test_name' => $test_name,
        ]);
    }
    
    public function actionResult($id_test = null, $id_theme = null, $id_timestamp = null)
    {
        $query_timestamp = Timestamp::find();
        if($id_timestamp){
            $query_timestamp->andWhere(['id' => $id_timestamp]);
        } 
        if ($id_test != null){
            $query_timestamp->andWhere(['id_theme_test' => $id_test, 'for' => Timestamp::TEST]);
        } elseif ($id_theme != null) {
            $query_timestamp->andWhere(['id_theme_test' => $id_theme, 'for' => Timestamp::THEME]);
        }
        $model = $query_timestamp->one();
        $dates = $query_timestamp->all();
        return $this->render('result',[
            'dates' => $dates,
            'model' => $model,
        ]);
    }
    
}
