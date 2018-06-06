<?php

namespace frontend\modules\zadarma\controllers;

use Yii;
use common\components\RController;
use backend\modules\zadarma\models\ZadarmaSearch;
use backend\modules\users\models\UsersContact;
use yii\helpers\ArrayHelper;

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
        $usersContactArray = ArrayHelper::map(UsersContact::findAll(['type' => 'zadarma']), 'value', 'user.fullNameInitials');
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
                'usersContactArray' => $usersContactArray,
            ]);
        }
        return $this->render('index');
    }
}
