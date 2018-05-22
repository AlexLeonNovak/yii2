<?php

namespace frontend\modules\zadarma\controllers;

use Yii;
use common\components\RController;
use backend\modules\zadarma\models\ZadarmaSearch;
use backend\modules\users\models\UsersContact;

/**
 * Default controller for the `zadarma` module
 */
class DefaultController extends RController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        
        $internal = UsersContact::find()->where(['type' => 'zadarma', 'id_user' => Yii::$app->user->id])->one();
        if (isset($internal)) {
            $searchModel = new ZadarmaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->andWhere([
                'OR',
                ['internal' => $internal->value],
                ['like', 'internal', ',' . $internal->value . ','],
                ['like', 'internal', ',' . $internal->value],
                ['like', 'internal', $internal->value . ','],
            ]);
            return $this->render('index',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('index');
    }
}
