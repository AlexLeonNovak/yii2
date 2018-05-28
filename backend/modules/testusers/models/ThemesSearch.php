<?php

namespace backend\modules\testusers\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\testusers\models\Themes;

/**
 * ThemesSearch represents the model behind the search form of `app\modules\testusers\models\Themes`.
 */
class ThemesSearch extends Themes
{
    public $id_group;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'id_group'], 'safe'],
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
        $query = Themes::find()->joinWith('groups');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        $query->filterWhere([
            'OR',
            ['users_group.id' => $this->id_group],
            ['test_themes.id_group' => $this->id_group]
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->distinct(['id']);
        
        return $dataProvider;
    }
}
