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
    public $call_start_date;
    public $answer_time_date;
    public $call_end_date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_code', 'duration'], 'integer'],
            [['type', 'pbx_call_id', 'internal', 'destination', 'disposition', 'is_recorded',
                'caller_id', 'call_start_date', 'answer_time_date', 'call_end_date'], 'safe'],
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
            'status_code' => $this->status_code,
            'duration' => $this->duration,
            'is_recorded' => $this->is_recorded,
            'disposition' => $this->disposition,
            'type' => $this->type,
        ]);
        
        $query->andFilterWhere(['like', 'pbx_call_id', $this->pbx_call_id])
            ->andFilterWhere(['like', 'internal', $this->internal])
            ->andFilterWhere(['like', 'destination', $this->destination])
            ->andFilterWhere(['like', 'caller_id', $this->caller_id])
            ->andFilterWhere(['>=', 'call_start', $this->call_start_date ? strtotime($this->call_start_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'call_start', $this->call_start_date ? strtotime($this->call_start_date . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'answer_time', $this->answer_time_date ? strtotime($this->answer_time_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'answer_time', $this->answer_time_date ? strtotime($this->answer_time_date . ' 23:59:59') : null])
            ->andFilterWhere(['>=', 'call_end', $this->call_end_date ? strtotime($this->call_end_date . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'call_end', $this->call_end_date ? strtotime($this->call_end_date . ' 23:59:59') : null]); 

        return $dataProvider;
    }
}
