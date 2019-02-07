<?php

namespace common\models\search;

use common\models\Helper;
use common\models\Member;
use common\models\Party;
use yii\base\Model;
use common\models\Ticket;
use yii\data\ActiveDataProvider;

/**
 * TicketSearch represents the model behind the search form of `common\models\Ticket`.
 *
 * @property array $columns
 *
 * @method array getAgeCondition( $field = null, $age = null );
 */
class TicketSearch extends Ticket {

    /** @var int $memberSex */
    public $memberSex;
    /** @var string $memberAge */
    public $memberAge;

    /**
     * @return array
     */
    public function attributes() {
        return array_merge([
            'memberSex', 'memberAge'
        ], parent::attributes());
    }

    /**
     * @return array
     */
    public function behaviors() {
        // unset updatedBy behavior:
        $parent = parent::behaviors();
        unset( $parent['operator'] );

        return array_merge([
            // attach age behavior:
           [
               'class'      => 'common\behavior\AgeBehavior',
               'field'      => 'member.age',
               'attribute'  => 'memberAge'
           ]
        ], $parent );
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
                     'memberSex'
                ], 'integer'
            ],
            [['memberAge'], 'string'],
            [['comment', 'created_at', 'updated_at' ], 'safe']
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
            ->joinWith('operator');

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
    public function getColumns() : array {
        // init operator ticket fields:
        $columns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'party_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var \common\models\Ticket $model */
                    return Helper::canLink(
                        'party.view',
                        $model->partyLabel,
                        $model->partyUrl
                    );
                },
                'filter' => Party::getDropDownList()[0]
            ],
            [
                'attribute' => 'member_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var \common\models\Ticket $model */
                    return Helper::canLink(
                        'member.view',
                        $model->memberLabel,
                        $model->memberUrl
                    );
                },
                'filter' => Member::getDropDownList()[0]
            ],
            [
                'attribute' => 'memberSex',
                'value' => function ($model) {
                    /** @var \common\models\Ticket $model */
                    return $model->memberSexLabel;
                },
                'filter' => Member::getSexDropDownList()
            ],
            [
                'attribute' => 'memberAge',
                'value' => function ($model) {
                    /** @var \common\models\Ticket $model */
                    return $model->memberAgeLabel;
                }
            ],
            'visited:boolean',
            'closed:boolean',
            'created_at:datetime'
        ];
        // check manager ticket fields:
        if( \Yii::$app->user->can('manager') ) {
            $columns = array_merge( $columns, [
                'paid:currency',
                'is_blocked:boolean',
                [
                    'attribute' => 'updated_by',
                    'format' => 'raw',
                    'value' => function( $model ) {
                        /** @var \common\models\Ticket $model */
                        return Helper::canLink(
                            'user.view',
                            $model->operatorLabel,
                            $model->operatorUrl
                        );
                    },
                    'filter' => \common\models\User::findRoleList()[0]
                ]
            ]);
        }
        // action column:
        $columns[] =             [
            'class' => 'yii\grid\ActionColumn',
            'visibleButtons' => Helper::visibleButtons('ticket')
        ];

        return $columns;
    }

    /**
     * @return array
     */
    protected function getDataSort() : array {
        return [
            'defaultOrder' => ['created_at' => SORT_DESC ],
            'attributes' => [
                'paid' => [ 'default' => SORT_DESC ],
                'closed' => [ 'default' => SORT_ASC ],
                'visited' => [ 'default' => SORT_ASC ],
                'is_blocked' => [ 'default' => SORT_ASC ],
                'updated_at' => [ 'default' => SORT_DESC ],
                'created_at' => [ 'default' => SORT_DESC ],
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
