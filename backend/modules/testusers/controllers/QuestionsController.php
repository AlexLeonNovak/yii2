<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\Questions;
use backend\modules\testusers\models\QuestionsSearch;
use backend\modules\testusers\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\components\RController;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends RController
{

    /**
     * Lists all Questions models.
     * @return mixed
     */
    public function actionIndex($id_test)
    {
        
        $searchModel = new QuestionsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //Добавляем фильтр по которому отображать вопросы соответствующие тесту
        $dataProvider->query->andWhere('id_test = '. $id_test);
        //Передаем имя теста
        $test = new TestSearch();
        $test_name = $test->findOne($id_test)->name;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'test_name'  => $test_name,
        ]);
    }

    /**
     * Creates a new Questions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_test)
    {
        $model = new Questions();
        $model->id_test = $id_test;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Данные сохранены");
            return $this->redirect(ArrayHelper::merge(['index'] ,Yii::$app->request->queryParams));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Questions model.
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
                        'id_test' => Yii::$app->request->get('id_test'),
                        'id_theme' => Yii::$app->request->get('id_theme'),
                    ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Questions model.
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
                     "<strong>Невозможно удалить вопрос, т.к. уже кто-то отвечал на него!</strong>"
//                     . "<hr />Мы можем "
//                     . Html::a('посмотреть результаты', ['/testusers/options/statistic-detail', 'id' => $id],
//                            ['class' => 'alert-link'])
//                     . " кто проходил."
            );
        }
        return $this->redirect([
                'index',
                'id_test' => Yii::$app->request->get('id_test'),
                'id_theme' => Yii::$app->request->get('id_theme'),
            ]);
    }

    /**
     * Finds the Questions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Questions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
