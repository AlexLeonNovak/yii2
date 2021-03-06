<?php

namespace backend\modules\testusers\controllers;

use Yii;
use backend\modules\testusers\models\Themes;
use backend\modules\testusers\models\ThemesSearch;
use backend\modules\testusers\models\TestThemesUsersGroup;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\Html;
use backend\modules\testusers\models\Timestamp;
use common\components\RController;
use yii\base\Model;

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
     * Creates a new Themes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Themes();
        $groups = new TestThemesUsersGroup();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveThemeGroups($model);
            Yii::$app->session->setFlash('success', "Данные сохранены");
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'groups' => $groups,
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
        $groups = $model->groups;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->saveThemeGroups($model);
            Yii::$app->session->setFlash('success', "Данные сохранены");
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }
    
    public function saveThemeGroups($theme) 
    {
        if (empty($data = Yii::$app->request->post('TestThemesUsersGroup', []))){
            return false;
        } else {
            TestThemesUsersGroup::deleteAll(['id_theme' => $theme->id]);
            foreach ($data['id_group'] as $dat){
                if ($dat != $theme->id_group){
                    $group = new TestThemesUsersGroup();
                    $group->id_group = $dat;
                    $group->id_theme = $theme->id;
                    $group->save();
                }
            }
        }
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
