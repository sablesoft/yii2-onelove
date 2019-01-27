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
               'attribute'  => 'memberAge',
               'field'      => 'member.age'
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
        $query = Ticket::find()->joinWith('member');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
}
