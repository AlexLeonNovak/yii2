<?php

namespace app\modules\testusers\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\testusers\models\Themes;

/**
 * ThemesSearch represents the model behind the search form of `app\modules\testusers\models\Themes`.
 */
class ThemesSearch extends Themes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_group'], 'integer'],
            [['name'], 'safe'],
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
        $query = Themes::find();

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
            'id_group' => $this->id_group,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
