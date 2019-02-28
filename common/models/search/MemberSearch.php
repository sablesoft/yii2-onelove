<?php

namespace common\models\search;

use yii\base\Model;
use yii\db\ActiveQuery;
use common\models\Member;
use common\models\Helper;
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
            [['id', 'user_id', 'sex', 'is_blocked', 'group_id'], 'integer'],
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

    public function getColumns() {
        $area = 'member';
        $columns = [
            ['class' => 'yii\grid\SerialColumn'],
            // todo - photo column

//                [
//                    'attribute' => 'photo',
//                    'value' => function( $model ) {
//                        /** @var \common\models\Member $model */
//                        return $model->getImagePath([ 'width' => 100 ]);
//                    },
//                    'format' => 'image',
//                    'enableSorting' => false,
//                    'filter' => false
//                ],
            'name',
            [
                'attribute' => 'sex',
                'value' => function ($model) {
                    /** @var \common\models\Member $model */
                    return $model->sexLabel;
                },
                'filter' => Member::getSexDropDownList()
            ],
            [
                'attribute' => 'age',
                'value' => function ($model) {
                    /** @var \common\models\Member $model */
                    return $model->ageLabel;
                }
            ],
            [
                'attribute' => 'group_id',
                'value'     => function( $model ) {
                    /** @var \common\models\Member $model */
                    return $model->groupLabel;
                },
                'filter' => \common\models\Group::getDropDownList()[0]
            ],
            [
                'attribute' => 'phone',
                'value' => function ($model) {
                    /** @var \common\models\Member $model */
                    return $model->maskedPhone;
                }
            ],
            'email:email',
            'visitsCount:integer'
        ];

        if( \Yii::$app->user->can('manager') )
            $columns = array_merge( $columns, [
                'visitsPay:decimal',
                'is_blocked:boolean'
            ]);

        return array_merge( $columns, [
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ]
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
            'group_id' => $this->group_id,
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
