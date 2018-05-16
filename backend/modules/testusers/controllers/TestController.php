<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\Test;
use backend\modules\testusers\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\testusers\models\ThemesSearch;
use common\components\RController;

/**
 * TestController implements the CRUD actions for test model.
 */
class TestController extends RController
{

    /**
     * Lists all test models.
     * @return mixed
     */
    public function actionIndex($id_theme)
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_theme = '. $id_theme);
        $theme_name = ThemesSearch::findOne($id_theme)->name;
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'theme_name' => $theme_name,
        ]);
    }

    /**
     * Displays a single test model.
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
     * Creates a new test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_theme)
    {
        $model = new Test();
        $model->id_theme = $id_theme;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Данные сохранены");
            return $this->actionIndex($id_theme);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing test model.
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
            return $this->redirect([
                        'index',
                        'id_theme' => Yii::$app->request->get('id_theme')
                    ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
                     "<strong>Невозможно удалить тест, т.к. уже кто-то проходил этот тест!</strong>"
//                     . "<hr />Мы можем "
//                     . Html::a('посмотреть результаты', ['/testusers/options/statistic-detail', 'id' => $id],
//                            ['class' => 'alert-link'])
//                     . " кто проходил."
            );
        }
        return $this->redirect([
                'index',
                'id_theme' => Yii::$app->request->get('id_theme'),
            ]);
    }

    /**
     * Finds the test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
