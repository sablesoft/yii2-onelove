<?php

namespace backend\models\search;

use yii\base\Model;
use common\models\Helper;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use backend\models\Statistic;

/**
 * StatisticSearch represents the model behind the search form of `backend\models\Statistic`.
 *
 * @property array $columns
 * @property array $groupLabels
 * @property string $timeFormat
 * @property string $timeSelect
 * @property string[] $sumFields
 */
class StatisticSearch extends Statistic {

    const GROUP_DATE        = 0;
    const GROUP_WEEK        = 1;
    const GROUP_MONTH       = 2;

    const SHOW_VIEWS    = 0;
    const SHOW_ASKS     = 1;
    const SHOW_PARTIES  = 2;
    const SHOW_MEMBERS  = 3;

    public $dateTo;
    public $dateFrom;
    public $operatorIds;

    public $showViews   = 1;
    public $showAsks    = 1;
    public $showParties = 1;
    public $showMembers = 1;

    /** @var array $_show - show flags */
    protected $_show = [];
    /** @var array $_groups - show groups */
    protected $_groups = [
        self::SHOW_VIEWS    => 'views',
        self::SHOW_ASKS     => 'asks',
        self::SHOW_PARTIES  => 'parties',
        self::SHOW_MEMBERS  => 'members'
    ];
    /** @var array $_fields - show fields */
    protected $_fields = [
        self::SHOW_VIEWS    => ['view_desk', 'view_mobile'],
        self::SHOW_ASKS     => ['ask_make', 'ask_reject', 'ask_member', 'ask_accept'],
        self::SHOW_PARTIES  => ['party_close', 'ticket_close'],
        self::SHOW_MEMBERS  => ['member_visit', 'member_pay']
    ];

    public $groupBy = self::GROUP_DATE;

    protected $_formats = [
        self::GROUP_DATE    => [ 'date', 'php:Y-m-d' ],
        self::GROUP_WEEK    => 'integer',
        self::GROUP_MONTH   => 'text'
    ];

    protected $_time = [
        self::GROUP_DATE    => '`statistic`.`date` as time',
        self::GROUP_WEEK    => 'WEEK(`statistic`.`date`, 1) as time',
        self::GROUP_MONTH   => 'MONTHNAME(`statistic`.`date`) as time'
    ];

    /**
     * @return array
     */
    public function getGroupLabels() : array {
        return [
            self::GROUP_DATE    => \Yii::t('app/backend', 'Dates'),
            self::GROUP_WEEK    => \Yii::t('app/backend', 'Weeks'),
            self::GROUP_MONTH   => \Yii::t('app/backend', 'Months')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['groupBy', 'showViews', 'showAsks', 'showParties', 'showMembers'], 'integer'],
            [['dateFrom', 'dateTo'], 'date', 'format' => 'php:Y-m-d'],
            [['dateFrom', 'dateTo'], 'validateRange'],
            [['operatorIds'], 'safe'],
            [['time'],'string']
        ];
    }

    public function afterValidate() {
        parent::afterValidate();
        // prepare column groups flags if no errors:
        if( !$this->hasErrors() )
            foreach( $this->_groups as $i => $group ) {
                $field = 'show' . ucfirst( $group );
                $this->_show[ $i ] = $this->$field;
            }
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [];
    }

    /**
     * @return bool
     */
    public function validateRange() : bool {
        if( $this->dateFrom && $this->dateTo  ) {
            $from = date( $this->dateFrom );
            $to = date( $this->dateTo );
            if( $from > $to ) {
                $error = \Yii::t('app/backend', 'Invalid time range!');
                $this->addError('dateFrom', $error );
                $this->addError('dateTo', $error );

                return false;
            }
        }

        return true;
    }

    /**
     * @return string|array
     */
    public function getTimeFormat() {
        return $this->_formats[ $this->groupBy ];
    }

    /**
     * @return string
     */
    public function getTimeSelect() : string {
        return $this->_time[ $this->groupBy ];
    }

    /**
     * @param null|integer $group
     * @return array
     */
    public function getSumFields( $group = null ) : array {
        $fields = [];
        if( !is_null( $group ) && array_key_exists( $group, $this->_fields ) )
            return $this->_fields[ $group ];

        foreach( $this->_fields as $showGroup )
            $fields = array_merge( $fields, $showGroup );

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return array_merge( parent::attributeLabels(), [
            'dateTo'        => \Yii::t('app/backend', 'To'),
            'dateFrom'      => \Yii::t('app/backend', 'From'),
            'groupBy'       => \Yii::t('app/backend', 'Group By'),
            'operatorIds'   => \Yii::t('app/backend', 'Operators filter'),
            'showViews'     => \Yii::t('app/backend', 'Views'),
            'showAsks'      => \Yii::t('app/backend', 'Asks'),
            'showParties'   => \Yii::t('app/backend', 'Parties'),
            'showMembers'   => \Yii::t('app/backend', 'Members')
        ]);
    }

    public function showOperators() : bool {
        return ( !empty( $this->operatorIds ) && !$this->groupBy );
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
    public function getColumns() : array {
        $columns[] = [
            'attribute' => 'time',
            'label' => $this->getGroupLabels()[ $this->groupBy ],
            'format' => $this->timeFormat,
            'pageSummary' => \Yii::t('app/backend', 'Total:')
        ];
        if( $this->showOperators() )
            $columns[] = [
                'attribute' => 'operator_id',
                'value' => function( $model ) {
                    /** @var \backend\models\Statistic $model */
                    return Helper::canLink(
                        'user.view', $model->operatorLabel,
                        $model->operatorUrl // todo - check
                    );
                },
                'enableSorting' => false,
                'filter' => false,
                'group' => true
            ];

        foreach( $this->_show as $group => $show )
            if( $show )
                foreach( $this->getSumFields( $group ) as $field )
                    $sums[] = [
                        'attribute' => $field,
                        'pageSummary' => true,
                        'enableSorting' => false,
                        'pageSummaryFunc' => GridView::F_SUM,
                        'filter' => false
                    ];

        return array_merge( $columns, (array) $sums );
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search( $params ) {
        $query = Statistic::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load( $params );

        if( !$this->validate() )
            return $dataProvider;

        $select[] = $this->timeSelect;
        foreach( $this->sumFields as $field )
            $select[] = !$this->showOperators() ?
                "sum(`statistic`.`$field`) as $field" : $field;

        if( $this->showOperators() ) {
            $select[] = 'operator_id';
        } else
            $query->groupBy('time');

        $query->select( $select )->orderBy('time');

        // grid filtering conditions
        $query->andFilterWhere([
            'operator_id' => $this->operatorIds
        ])->andFilterWhere([
            '>=', 'date', $this->dateFrom
        ])->andFilterWhere([
            '<=', 'date', $this->dateTo
        ]);

        return $dataProvider;
    }
}
