{* @var Ask $ask *}
{* @var string $formId *}
{* @var string $leftColumnClass *}
{* @var string $rightColumnClass *}
{use class="yii\helpers\Html"}
{use class="common\models\Group"}
{$groupList = Group::getDropDownList()}
{$groupList = $groupList[0]}
{ActiveForm assign='form' action='/ask/create'
    options=['id' => $formId, 'class' => 'registration-form ask-form' ]
    enableAjaxValidation=true validationUrl='/ask/validate'}
    <div class="row">
        <div class="{$leftColumnClass}">
            {$form->field( $ask, 'name' )->textInput([
                'placeholder' => Yii::t('app', 'Name')
            ])->label(false)}
            {$form->field( $ask, 'phone')
                ->widget(
                    'yii\widgets\MaskedInput',
                    $ask->getMaskedPhoneConfig([
                    'options' => [
                        'id' => "$formId-phone-mask",
                        'placeholder' => Yii::t('app', 'Phone')
                    ]
                ])
            )->label(false)}
            {$form->field( $ask, 'group_id' )->label(Yii::t('app', 'What age of the opposite sex is preferable for you?'))
                ->dropDownList( $groupList )}
            <div class="form-group">
                {Html::input('submit', 'submit', Yii::t('app', 'Send Ask') )}
            </div>
        </div>
        <div class="{$rightColumnClass}">
            {$form->field( $ask, 'sex' )->radioList([
                1 => Yii::t('app', 'M'),
                0 => Yii::t('app', 'Ж')
            ])}
            {$form->field( $ask, 'age' )->input('number')}
        </div>
    </div>
{/ActiveForm}