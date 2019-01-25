<?php

namespace common\models\search;

use yii\base\Model;
use yii\db\ActiveQuery;
use common\models\Party;
use yii\data\ActiveDataProvider;
use common\interfaces\SearchInterface;
use common\behavior\DateFilterBehavior;

/**
 * PartySearch represents the model behind the search form of `common\models\Party`.
 *
 * @method ActiveQuery applyDateFilter( string $attribute, ActiveQuery $query );
 */
class PartySearch extends Party implements SearchInterface {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'place_id', 'price_id', 'max_members', 'is_blocked', 'closed'], 'integer'],
            [['timestamp', 'name', 'description', 'phone', 'created_at', 'updated_at'], 'safe'],
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
     * @return array
     */
    public function behaviors() {
        return array_merge( parent::behaviors(), [
            DateFilterBehavior::class
        ]);
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
            'id'            => $this->id,
            'place_id'      => $this->place_id,
            'price_id'      => $this->place_id,
            'max_members'   => $this->max_members,
            'is_blocked'    => $this->is_blocked,
            'closed'        => $this->closed
        ]);

        // date filter:
        $query = $this->applyDateFilter( 'created_at', $query );
        $query = $this->applyDateFilter( 'updated_at', $query );
        $query = $this->applyDateFilter( 'timestamp', $query );

        $query->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
