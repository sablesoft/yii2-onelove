<?php

namespace common\models\search;

use yii\base\Model;
use common\models\Place;
use yii\data\ActiveDataProvider;
use common\interfaces\SearchInterface;

/**
 * PlaceSearch represents the model behind the search form of `common\models\Place`.
 */
class PlaceSearch extends Place implements SearchInterface {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'is_default'], 'integer'],
            [['name', 'address', 'phone', 'created_at', 'updated_at'], 'safe']
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
        $query = Place::find();

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
            'is_default' => $this->is_default,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
