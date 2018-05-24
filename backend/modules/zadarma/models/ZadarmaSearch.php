<?php

namespace backend\modules\zadarma\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\zadarma\models\Zadarma;

/**
 * ZadarmaSearch represents the model behind the search form of `backend\modules\zadarma\models\Zadarma`.
 */
class ZadarmaSearch extends Zadarma
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'call_start', 'answer_time', 'call_end', 'status_code', 'duration'], 'integer'],
            [['type', 'pbx_call_id', 'internal', 'destination', 'disposition', 'is_recorded', 'call_id_with_rec'], 'safe'],
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
        $query = Zadarma::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->defaultOrder= ['id' => SORT_DESC];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'call_start' => $this->call_start,
            'answer_time' => $this->answer_time,
            'call_end' => $this->call_end,
            'status_code' => $this->status_code,
            'duration' => $this->duration,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'pbx_call_id', $this->pbx_call_id])
            ->andFilterWhere(['like', 'internal', $this->internal])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'disposition', $this->disposition])
            ->andFilterWhere(['like', 'is_recorded', $this->is_recorded])
            ->andFilterWhere(['like', 'call_id_with_rec', $this->call_id_with_rec]);

        return $dataProvider;
    }
}
