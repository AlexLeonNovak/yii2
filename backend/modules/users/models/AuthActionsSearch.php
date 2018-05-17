<?php

namespace backend\modules\users\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\users\models\AuthActions;

/**
 * AuthActionsSearch represents the model behind the search form of `backend\modules\users\models\AuthActions`.
 */
class AuthActionsSearch extends AuthActions
{
    public $module_name;
    public $controller_name;
    public $id_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_controller', 'id_user'], 'integer'],
            [['name', 'description', 'module_name', 'controller_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AuthActions::find()->joinWith(['controller', 'module']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ]
        ]);
        $dataProvider->sort->enableMultiSort = true;
        $dataProvider->setSort([
            'attributes' =>[
                'module_name' => [
                    'asc'  => ['auth_modules.name' => SORT_ASC, 'auth_controllers.name' => SORT_ASC],
                    'desc' => ['auth_modules.name' => SORT_DESC, 'auth_controllers.name' => SORT_DESC],
                ],
                'controller_name' => [
                    'asc'  => ['auth_controllers.name' => SORT_ASC],
                    'desc' => ['auth_controllers.name' => SORT_DESC],
                ],
                'name' => [
                    'asc'  => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                ],
            ],
            'defaultOrder'=>[
                'module_name' => SORT_ASC
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(['auth_actions.id_controller' => $this->id_controller]);
        if ($this->id_user){
            $query->andFilterWhere(['auth_actions.id' => Yii::$app->authManager->getAccessArrayActionsByUserId($this->id_user)]);
        } else {
            $query->andFilterWhere(['auth_actions.id' => $this->id]);
        }
        
        $query->andFilterWhere([
                    'or',
                    ['like', 'auth_actions.name', $this->name],
                    ['like', 'auth_actions.description', $this->name]
                ])
            ->andFilterWhere([
                    'or',
                    ['like', 'auth_modules.name', $this->module_name],
                    ['like', 'auth_modules.description', $this->module_name]
                ])
            ->andFilterWhere([
                    'or',
                    ['like', 'auth_controllers.name', $this->controller_name],
                    ['like', 'auth_controllers.description', $this->controller_name]
                ]);
        return $dataProvider;
    }
}
