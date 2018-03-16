<?php

namespace backend\modules\testusers\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\modules\testusers\models\UserAnswer;
use backend\modules\testusers\models\UserAnswerSearch;
use backend\modules\testusers\models\Answers;
use backend\modules\testusers\models\Questions;
use backend\modules\testusers\models\Test;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\Timestamp;
use backend\modules\testusers\models\TimestampSearch;
use frontend\modules\testusers\controllers\DefaultController;
use common\models\User;
use backend\modules\users\models\UsersGroup;

/**
 * Description of StatisticController
 *
 * @author novak-ol
 */
class OptionsController extends Controller {

    public function actionStatistic(){
        $searchModel  = new TimestampSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('statistic', [
            'dataProvider'  => $dataProvider,
            'searchModel'   => $searchModel,
        ]);
    }
    
    public function actionStatisticDetail($id)
    {
        $model = Timestamp::findOne($id);
        $dataProvider = new ActiveDataProvider([
            'query' =>  $model->getUserAnswers()]);
        $user_answers = UserAnswer::findAll(['id_timestamp' => $model->id]);
        foreach ($user_answers as $user_answer){
            $dataProviderAnswers[$user_answer->id] = new ActiveDataProvider([
                'query' => $user_answer->getAnswers(),
            ]);
            //$questions[$user_answer->id] = $user_answer->question->question;
        }
        //var_dump($questions);
        //$model_questions = Questions::findAll($model->questions);

        return $this->render('statistic-detail',[
            'model'                 => $model,
            'dataProvider'          => $dataProvider,
            'dataProviderAnswers'   => $dataProviderAnswers,
            'questions'             => $questions,
            'user_answers'          => $user_answers,
        ]);
    }
    
    public function actionSettings()
    {
        return $this->render('settings');
    }
}
