<?php

namespace app\modules\testusers\controllers;

use Yii;
use app\modules\testusers\models\Answers;
use app\modules\testusers\models\AnswersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;
use yii\web\Response;

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
    public function actionCreate($id_question) {
        $error = 0;
        $model = new Answers();
        $model->id_question = $id_question;
        // создаем на каждый набор данных в массиве модель
        if($data = Yii::$app->request->post('Answers')["answers_form"]){
            //var_dump($data);die;
            
            $models = [new Answers()];
            foreach ($data as $key => $value) {
                //var_dump($value['answer']);die;
                $models[$key] = new Answers();
                $models[$key]->answer = $value['answer'];
                $models[$key]->correct = $value['correct'];
                $models[$key]->id_question = $id_question;
                //var_dump($models[$key]);die;
                if ($models[$key]->validate() && $models[$key]->save()) {
                    
                } else {
                    $error++;
                }
            }
            //var_dump($error);die;
           if($error == 0){
                return $this->actionIndex($id_question);
            }
        }
                
        return $this->render('create', [
            'model' => $model,
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
