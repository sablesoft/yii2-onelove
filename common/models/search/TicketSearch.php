<?php

namespace common\models\search;

use yii\base\Model;
use common\models\Ticket;
use yii\data\ActiveDataProvider;

/**
 * TicketSearch represents the model behind the search form of `common\models\Ticket`.
 *
 * @method array getAgeCondition( $field = null, $age = null );
 */
class TicketSearch extends Ticket {

    /** @var int $memberSex */
    public $memberSex;
    /** @var string $memberAge */
    public $memberAge;

    public function attributes() {
        return array_merge([
            'memberSex', 'memberAge'
        ], parent::attributes());
    }

    public function behaviors()
    {
        return array_merge([
           [
               'class'      => 'common\behavior\AgeBehavior',
               'field'      => 'member.age',
               'attribute'  => 'memberAge'
           ]
        ], parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [
                [
                    'id', 'party_id', 'member_id', 'visited',
                    'paid', 'is_blocked', 'closed', 'updated_by',
                    'created_at', 'updated_at', 'memberSex'
                ], 'integer'
            ],
            [['memberAge'], 'string'],
            [['comment'], 'safe']
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
    public function search( $params ) {
        $query = Ticket::find()
            ->joinWith('party')
            ->joinWith('member')
            ->joinWith('updatedBy');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $this->getDataSort()
        ]);

        $this->load( $params );

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'paid' => $this->paid,
            'closed' => $this->closed,
            'visited' => $this->visited,
            'party_id' => $this->party_id,
            'member_id' => $this->member_id,
            'is_blocked' => $this->is_blocked,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'member.sex' => $this->memberSex
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
                ->andFilterWhere( $this->getAgeCondition() );

        return $dataProvider;
    }

    /**
     * @return array
     */
    protected function getDataSort() : array {
        return [
            'attributes' => [
                'paid', 'closed', 'visited', 'is_blocked', 'updated_at', 'created_at',
                'memberSex' => [
                    'asc' => [ 'member.sex' => SORT_ASC ],
                    'desc' => [ 'member.sex' => SORT_DESC ],
                    'default' => SORT_DESC
                ],
                'memberAge' => [
                    'asc' => [ 'member.age' => SORT_ASC ],
                    'desc' => [ 'member.age' => SORT_DESC ],
                    'default' => SORT_DESC
                ],
                'updated_by' => [
                    'asc' => [ 'user.username' => SORT_ASC ],
                    'desc' => [ 'user.username' => SORT_DESC ],
                    'default' => SORT_DESC
                ],
                'member_id' => [
                    'asc' => [ 'member.name' => SORT_ASC ],
                    'desc' => [ 'member.name' => SORT_DESC ],
                    'default' => SORT_DESC
                ],
                'party_id' => [
                    'asc' => [ 'party.name' => SORT_ASC ],
                    'desc' => [ 'party.name' => SORT_DESC ],
                    'default' => SORT_DESC
                ]
            ]
        ];
    }
}
