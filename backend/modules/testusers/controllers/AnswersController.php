<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\Answers;
use yii\base\Model;
use yii\web\Response;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\components\RController;

/**
 * AnswersController implements the CRUD actions for Answers model.
 */
class AnswersController extends RController
{

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
                    }
                    $model->answer = $dat['answer'];
                    $model->correct = $dat['correct'];
                    $model->id_question = $id_question;
                    $model->save(false);
                }
                $models = Answers::findAll(['id_question' => $id_question]);
                Yii::$app->session->setFlash('success', "Данные сохранены");
                return $this->redirect([
                        '/testusers/questions/index',
                        'id_test' => Yii::$app->request->get('id_test'),
                        'id_theme' => Yii::$app->request->get('id_theme'),
                    ]);
            }
        
        return $this->render('create', [
            'models' => $models,
        ]);
    }

}
