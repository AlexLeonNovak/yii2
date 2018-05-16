<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\ThemesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use backend\modules\testusers\models\Timestamp;
use common\components\RController;

/**
 * ThemesController implements the CRUD actions for Themes model.
 */
class ThemesController extends RController
{


    /**
     * Lists all Themes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThemesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Themes model.
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
     * Creates a new Themes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Themes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Данные сохранены");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Themes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Данные сохранены");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Themes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id id_test
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', "Данные удалены");
        } catch (\yii\db\Exception $e) {

            Yii::$app->session->setFlash('danger',
                     "<strong>Невозможно удалить тему, т.к. уже кто-то проходил один из тестов из этой темы!</strong>"
                     . "<hr />Мы можем "
                     . Html::a('удалить эти записи', ['delete-test-users', 'id' => $id],
                            [
                                'class' => 'alert-link',
                                'linkOptions' => [
                                    'data-method' => 'post'
                                    ]
                            ])
                     . " безвозвратно."
            );
        }
        
        return $this->redirect(['index']);
    }
    
    public function actionDeleteTestUsers($id)
    {
        if (Timestamp::deleteUserAnswers($id)){
            Yii::$app->session->setFlash('success', "<strong>Данные удалены</strong>"
                    . "<br />Теперь можно удалить тему");
        } else {
            Yii::$app->session->setFlash('danger', "Что-то пошло не так");
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Themes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Themes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Themes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
