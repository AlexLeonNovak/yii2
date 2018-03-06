<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\Answers;
use backend\modules\testusers\models\AnswersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * AnswersController implements the CRUD actions for Answers model.
 */
class AnswersController extends Controller
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

    /**
     * Lists all Answers models.
     * @return mixed
     */
    public function actionIndex($id_question)
    {
        $searchModel = new AnswersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_question = '. $id_question);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answers model.
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
     * Creates a new Answers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_question) 
    {
        $models = Answers::findAll(['id_question' => $id_question]);
        if(!$models){
            $models = [new Answers()];
        }
        $request = Yii::$app->getRequest();
        if ($request->isPost && $request->post('ajax') !== null) {
            $data = Yii::$app->request->post('Answers', []);
            foreach (array_keys($data) as $index) {
                $models[$index] = new Answers();
            }
            Model::loadMultiple($models, Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result = ActiveForm::validateMultiple($models);
            return $result;
        }
        if ($request->isPost){
            $data = Yii::$app->request->post('Answers', []);
            if (Model::loadMultiple($models, Yii::$app->request->post())) {
                try {
                    Answers::deleteAll([
                        'AND',
                        ['id_question' => $id_question],
                        ['not in', 'id', ArrayHelper::getColumn($data,'id')]
                ]);        
                } catch (\yii\db\Exception $e) {
                    Yii::$app->session->setFlash('danger', "Одно или несколько записей не были удалены!"
                            . "<br /><small>Возможно, что кто-то уже выбрал один из ответов"
                            . "<br />Попробуйте изменить ответ или удалить другой ответ</small>");
                }
            }
                foreach ($data as $dat){
                    if ($dat['id'] != null){
                        $model = Answers::findOne(['id' => $dat['id']]);
                    } else {
                        $model = new Answers();
                        $model->answer = $dat['answer'];
                    }
                    $model->correct = $dat['correct'];
                    $model->id_question = $id_question;
                    $model->save(false);
                }
                $models = Answers::findAll(['id_question' => $id_question]);
                Yii::$app->session->setFlash('success', "Данные сохранены");
            }
        
        return $this->render('create', [
            'models' => $models,
        ]);
    }

    /**
     * Updates an existing Answers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Answers model.
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
     * Finds the Answers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
