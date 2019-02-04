{* @var CallForm $call *}
{* @var string $formId *}
{$formId='registration-form-back-call'}
{use class="yii\helpers\Html"}

<article class="registration-back-call form-modal">
    <i class="fas fa-times close"></i>
    <h2>Клуб знакомств <span>OneLove</span></h2>

    {ActiveForm assign='form' action='/ask/call'
        options=['id' => $formId, 'class' => 'registration-form-back ask-form' ]
        enableAjaxValidation=true validationUrl='/ask/call-validate'}
        <div class="row">
            <div class="col-sm-12">
                {$form->field( $call, 'name' )->textInput([
                    'placeholder' => Yii::t('app/frontend', 'Name')
                ])->label(false)}
                {$form->field( $call, 'phone')
                    ->widget(
                        'yii\widgets\MaskedInput',
                        $ask->getMaskedPhoneConfig([
                        'options' => [
                            'id' => "$formId-phone-mask",
                            'placeholder' => Yii::t('app/frontend', 'Phone')
                        ]
                    ])
                )->label(false)}
                <div class="form-group">
                    {Html::input('submit', 'submit', Yii::t('app/frontend', 'Send Ask') )}
                </div>
            </div>
        </div>
    {/ActiveForm}

</article>