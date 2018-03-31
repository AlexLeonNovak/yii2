<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\TestSettings;
use backend\modules\testusers\models\TestSettingsSearch;
use backend\modules\testusers\models\TestMsg;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestSettingsController implements the CRUD actions for TestSettings model.
 */
class TestSettingsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    function actions(){
        return [
            'msg-update' => [
                'class' => 'pheme\settings\SettingsAction',
                'modelClass' => 'backend\modules\testusers\models\TestMsg',
                //'scenario' => 'site',	// Change if you want to re-use the model for multiple setting form.
                'viewName' => 'msg-update'	// The form we need to render
            ],
        ];
    }
    public function beforeAction($action)
    {
        Yii::$app->getModule('settings')->init(); // make sure this module is init first
        return parent::beforeAction($action);
    }
    /**
     * Lists all TestSettings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSettingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TestSettings model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TestSettings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TestSettings();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TestSettings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
//    public function actionMsgUpdate()
//    {
////        $model = TestMsg
////        var_dump($model);
////        if ($model->load(Yii::$app->request->post()) && $model->save()) {
////            return $this->redirect(['index']);
////        }
//
//        return $this->render('msg-update', [
//            'model' => $model,
//        ]);
//    }
    /**
     * Deletes an existing TestSettings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TestSettings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TestSettings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TestSettings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
