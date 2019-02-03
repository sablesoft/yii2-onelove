<?php

namespace common\models\search;

use common\behavior\DateFilterBehavior;
use yii\base\Model;
use common\models\Ask;
use yii\data\ActiveDataProvider;
use common\interfaces\SearchInterface;
use yii\db\ActiveQuery;

/**
 * AskSearch represents the model behind the search form of `Ask`.
 *
 * @method ActiveQuery applyDateFilter( string $attribute, ActiveQuery $query );
 * @method array getAgeCondition( $field = null, $age = null );
 */
class AskSearch extends Ask implements SearchInterface {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sex', 'group_id' ], 'integer'],
            [['name', 'phone', 'created_at', 'updated_at', 'age'], 'safe']
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

        $query = Ask::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC
                ]
            ]
        ]);

        $this->load( $params );

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'sex' => $this->sex,
            'group_id' => $this->group_id
        ]);

        // date filter:
        $query = $this->applyDateFilter( 'created_at', $query );
        $query = $this->applyDateFilter( 'updated_at', $query );

        $query->andFilterWhere(['like', 'name', $this->name ])
            ->andFilterWhere(['like', 'phone', $this->phone ])
            ->andFilterWhere( $this->getAgeCondition() );

        return $dataProvider;
    }
}
