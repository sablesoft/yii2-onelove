<?php

namespace common\models\search;

use yii\base\Model;
use common\models\Party;
use yii\data\ActiveDataProvider;
use common\interfaces\SearchInterface;

/**
 * PartySearch represents the model behind the search form of `common\models\Party`.
 */
class PartySearch extends Party implements SearchInterface {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // todo - date and time dynamic fields
            [['id', 'place_id', 'price_id', 'max_members'], 'integer'],
            [['timestamp', 'name', 'description', 'created_at', 'updated_at'], 'safe'],
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
        $query = Party::find();

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
            'id'            => $this->id,
            'place_id'      => $this->place_id,
            'price_id'      => $this->place_id,
            'timestamp'     => $this->timestamp,
            'max_members'   => $this->max_members,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
