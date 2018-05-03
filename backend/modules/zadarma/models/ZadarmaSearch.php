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
            [['id', 'duration', 'caller_id', 'called_did', 'internal', 'status_code'], 'integer'],
            [['event', 'call_start', 'pbx_call_id', 'destination', 'disposition', 'is_recorded'], 'safe'],
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'duration' => $this->duration,
            'caller_id' => $this->caller_id,
            'called_did' => $this->called_did,
            'internal' => $this->internal,
            'status_code' => $this->status_code,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event])
            ->andFilterWhere(['like', 'call_start', $this->call_start])
            ->andFilterWhere(['like', 'pbx_call_id', $this->pbx_call_id])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'disposition', $this->disposition])
            ->andFilterWhere(['like', 'is_recorded', $this->is_recorded]);

        return $dataProvider;
    }
}
