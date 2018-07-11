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
use yii\helpers\ArrayHelper;
use common\models\User;
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
    
    public function actionDetail() 
    {
        $params['user_list'] = ArrayHelper::map(User::find()->all(), 'id', 'fullName', 'usersGroup.name');
        $request = Yii::$app->getRequest();
        if ($request->isPost) {
            $query = UserAnswer::find();
            $times = $query->select(['ids' => 'id_timestamp'])
                ->distinct()
                ->where(['id_user' => $request->post('id_user')])
                ->column();
            $params['selected'] = $request->post('id_user');
            if ($times) {
                $searchModel  = new TimestampSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->andFilterWhere([Timestamp::tableName().'.id' => $times]);
                $dataProvider->pagination->pageSize = 50;
                $dataProvider->sort->defaultOrder= ['themeOrTest.name' => SORT_ASC, 'timestamp' => SORT_ASC];
                $params['dataProvider']  = $dataProvider;
            }
        }
        return $this->render('detail', $params);
    }
    
    public function actionDelete($id)
    {
        UserAnswer::deleteAll(['id_timestamp' => $id]);
        Timestamp::deleteAll(['id' => $id]);
        Yii::$app->session->setFlash('success','Удалено успешно');
        return Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();
    }
}
