<?php

namespace common\models\search;

use yii\base\Model;
use yii\db\ActiveQuery;
use common\models\Member;
use yii\data\ActiveDataProvider;
use common\interfaces\SearchInterface;
use common\behavior\DateFilterBehavior;

/**
 * MemberSearch represents the model behind the search form of `common\models\Member`.
 *
 * @method ActiveQuery applyDateFilter( string $attribute, ActiveQuery $query );
 * @method array getAgeCondition( $field = null, $age = null );
 */
class MemberSearch extends Member implements SearchInterface {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['age', 'string'],
            [['id', 'user_id', 'sex', 'is_blocked'], 'integer'],
            [['name', 'photo', 'dob', 'phone', 'email', 'resume', 'created_at', 'updated_at'], 'safe']
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
        $query = Member::find();

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
            'sex' => $this->sex,
            'user_id' => $this->user_id,
            'is_blocked' => $this->is_blocked
        ]);

        // date filter:
        $query = $this->applyDateFilter( 'dob', $query );
        $query = $this->applyDateFilter( 'created_at', $query );
        $query = $this->applyDateFilter( 'updated_at', $query );

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'resume', $this->resume])
            ->andFilterWhere( $this->getAgeCondition() );

        return $dataProvider;
    }
}
