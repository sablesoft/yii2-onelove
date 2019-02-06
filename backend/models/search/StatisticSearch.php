<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Statistic;

/**
 * StatisticSearch represents the model behind the search form of `backend\models\Statistic`.
 */
class StatisticSearch extends Statistic {
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'ask_make', 'ask_reject', 'ask_member', 'ask_accept', 'operator_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        $parent = parent::behaviors();
        unset( $parent['operator'] );
        return $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search( $params ) {
        $query = Statistic::find();

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
            'date' => $this->date,
            'ask_make' => $this->ask_make,
            'ask_reject' => $this->ask_reject,
            'ask_member' => $this->ask_member,
            'ask_accept' => $this->ask_accept,
            'operator_id' => $this->operator_id
        ]);

        return $dataProvider;
    }
}
