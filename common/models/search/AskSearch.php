<?php

namespace common\models\search;

use yii\base\Model;
use common\models\Ask;
use yii\data\ActiveDataProvider;
use common\interfaces\SearchInterface;

/**
 * AskSearch represents the model behind the search form of `Ask`.
 */
class AskSearch extends Ask implements SearchInterface {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'party_id', 'member_id', 'processed', 'confirmed', 'visited', 'paid'], 'integer']
        ];
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
    public function search( array $params ) : ActiveDataProvider {

        $query = Ask::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
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
            'party_id' => $this->party_id,
            'member_id' => $this->member_id,
            'processed' => $this->processed,
            'confirmed' => $this->confirmed,
            'visited' => $this->visited,
            'paid' => $this->paid
        ]);

        return $dataProvider;
    }
}
