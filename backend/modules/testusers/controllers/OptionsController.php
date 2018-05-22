<?php

namespace backend\modules\testusers\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use backend\modules\testusers\models\UserAnswer;
use backend\modules\testusers\models\Timestamp;
use backend\modules\testusers\models\TimestampSearch;
use common\components\RController;
/**
 * Description of StatisticController
 *
 * @author novak-ol
 */
class OptionsController extends RController {

    
    public function actionStatistic()
    {
        $searchModel  = new TimestampSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('statistic', [
            'dataProvider'  => $dataProvider,
            'searchModel'   => $searchModel,
        ]);
    }
    
    public function actionView($id)
    {
        $model = Timestamp::findOne($id);
        $dataProvider = new ActiveDataProvider([
            'query' =>  $model->getUserAnswers(),
            'pagination' => [
                'pageSize' => 50
                ]
            ]);
        $user_answers = UserAnswer::findAll(['id_timestamp' => $model->id]);
        foreach ($user_answers as $user_answer){
            $dataProviderAnswers[$user_answer->id] = new ActiveDataProvider([
                'query' => $user_answer->getAnswers(),
            ]);
        }

        return $this->render('view',[
            'model'                 => $model,
            'dataProvider'          => $dataProvider,
            'dataProviderAnswers'   => $dataProviderAnswers,
            'user_answers'          => $user_answers,
        ]);
    }
    
    public function actionDetail($id_user) 
    {
        $model = UserAnswer::findAll(['id_user' => $id_user]);
        
        return $this->render('detail', [
            'model'                 => $model,
            //'dataProvider'          => $dataProvider,
        ]);
    }
    
    public function actionDelete($id)
    {
        UserAnswer::deleteAll(['id_timestamp' => $id]);
        Timestamp::deleteAll(['id' => $id]);
        return $this->redirect(['statistic']);
    }
}
