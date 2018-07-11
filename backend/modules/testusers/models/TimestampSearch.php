<?php

namespace backend\modules\testusers\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\testusers\models\Timestamp;
use common\models\User;
use backend\modules\testusers\models\UserAnswerSearch;
use backend\modules\testusers\models\UserAnswer;

/**
 * TimestampSearch represents the model behind the search form of `backend\modules\testusers\models\Timestamp`.
 */
class TimestampSearch extends Timestamp
{
    public $id_user;
    public $id_group;
    public $answersCorrectCount;
    public $date;
    public $for_tt;
//    public $questions_count;
//    public $answers_count;
//    public $answers_correct_count;
    public $userAnswersCount;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_theme_test', 'timestamp', 'id_user', 'id_group'], 'integer'],
            [['userAnswersCount', 'date', 'for_tt'], 'safe'],
//            [['username', 'group_name', 'date', 'for', 'questions_count', 
//                'answers_count', 'answers_correct_count'], 'safe'],
//            [['themeOrTest'],'string'],
            [['for'], 'boolean'],
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
        $query = Timestamp::find()->with(['userAnswers'])->joinWith(['user', 'answer']);
        //$query->addSelect(['userAnswersCount' => $this->userAnswersCount]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id_user' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                ],
                'id_group' => [
                    'asc' => ['user.id_group' => SORT_ASC],
                    'desc' => ['user.id_group' => SORT_DESC],
                ],
                'timestamp',
                'for',
                'themeOrTest.name' => [
                    'asc' => ['for' => SORT_ASC, 'id_theme_test' => SORT_ASC],
                    'desc' => ['for' => SORT_DESC, 'id_theme_test' => SORT_DESC],
                ],
            ],
            'defaultOrder' => [
                'timestamp' => SORT_DESC
            ],
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
            'for' => $this->for,
            'id_theme_test' => $this->id_theme_test,
            'user.id' => $this->id_user,
            'user.id_group' => $this->id_group,
//            'themeOrTest.name' => $this->themeOrTest->name,
        ])
        ->andFilterWhere(['>=', 'timestamp', $this->date ? strtotime($this->date . ' 00:00:00') : null])
        ->andFilterWhere(['<=', 'timestamp', $this->date ? strtotime($this->date . ' 23:59:59') : null]);
        $query->distinct(['id']);
        //$query->andFilterWhere(['like', 'user.id', $this->id_user]);

        return $dataProvider;
    }
}
