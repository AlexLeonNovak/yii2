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
use yii\helpers\ArrayHelper;


/**
 * Default controller for the `testusers` module
 */
class DefaultController extends Controller
{
    const NOT_ANSWER = 0; //Нет ответа на вопрос
    private $ids_answer = [];       //массив с ид ответами, на которые пользователь ответил
    private $questions_showed = []; //массив с ид вопросами, которые были показаны
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
    private function getQuestion($id_test = null, $id_theme = null){
        if(Yii::$app->getRequest()->post('id_answer')){ //получаем ид ответа, который пользователь выбрал
                $this->ids_answer[] = Yii::$app->getRequest()->post('id_answer'); //записываем в масив
            } else {
                $this->ids_answer[] = self::NOT_ANSWER;  //если таймер обновил страницу, то пользователь ничего не выбрал
            }
        Yii::$app->session['ids_answer'] = $this->ids_answer; //записываем в сессию ответы
        $question_query = Questions::find();
        if ($id_test != null) {
            $question_query->Where(['id_test' => $id_test]);
        } elseif ($id_theme !=null){
            $ids_tests = Test::find(['id_theme' => $id_theme])->asArray()->all();
            $question_query->where(['id_test' => ArrayHelper::getColumn($ids_tests, 'id')]);
        } else { return false; }
        if (Yii::$app->session['questions']){
            $this->questions_showed = Yii::$app->session['questions'];
            $question_query->andFilterWhere(['not in', 'id', Yii::$app->session['questions']]);
            $this->ids_answer = Yii::$app->session['ids_answer'];
        }
        $question = $question_query->orderBy(new Expression('rand()'))->one();   
        //var_dump($question);
        $this->questions_showed[] = $question->id; //записываем в массив показаные вопросы
        Yii::$app->session['questions'] = $this->questions_showed; //запмсь в сессию этот массив (по другому почему-то не работает...)
        if (!Yii::$app->session['count_questions']){
            Yii::$app->session['count_questions'] = $question_query->count();
            Yii::$app->session['item_question'] = 1;
        }
        if (!$question) {
            return false;
        } else {
            Yii::$app->session['item_question']++;
            return $question;
        }
    }

    public function actionTest($id_test = null, $id_theme = null)
    {
        if (!Yii::$app->session['timestamp']){
            Yii::$app->session['timestamp'] = time();
        }
        $question = $this->getQuestion($id_test, $id_theme);
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
        $dates = [];
        $result = [];
        foreach ($times as $key => $time){
            $user_answers = UserAswer::findAll([
                        'id_user' => Yii::$app->user->identity->id,
                        'id_timestamp' => $time->id,
                    ]);
            $dates[] = Yii::$app->formatter->asDatetime($time->timestamp, 'php:d.m.Y H:i:s');
            
            foreach ($user_answers as $user_answer){
                $question = Questions::findOne([
                            'id' => $user_answer->id_question,
                            'id_test' => $id_test,
                        ]);
                if ($user_answer->id_answer){
                    $answer = Answers::findOne(['id' => $user_answer->id_answer]);
                } else {
                    $answer->answer = '<b><i>(Вы не ответили на этот вопрос)</i></b>';
                    $answer->correct = false;
                }
                $result[$key][] = [ 
                        'question'      => $question->question,
                        'answer'        => $answer->answer,
                        'is_correct'    => $answer->correct,
                ];
                
            }
            $provider[] = new ArrayDataProvider([
                    'allModels' => $result[$key],
                    'pagination' => [
                        'pageSize' => 10,
                    ],
                ]);
        }
        $test_name = Test::findOne(['id' => $id_test])->name;
        return $this->render('result',[
            'test_name' => $test_name,
            'provider'  => $provider,
            'dates'     => $dates,
        ]);
    }
    
}
