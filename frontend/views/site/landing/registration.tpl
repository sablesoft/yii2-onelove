{* @var $party Party *}
{* @var $ask Ask *}
{use class='common\models\Helper'}
{use class="yii\helpers\Html"}
<section class="registration">
    <div class="landing-wrapper">
        <img src="landing/img/sec1art1.png" alt="">
        <h1>Клуб знакомств <span>OneLove</span></h1>
        <article class="registration-description">
            <div class="registration-title">
                <h2 class="title">ключ к вашему совместному будущему</h2>
                <ul>
                    {$keys = Helper::getParams('keys')}
                    {foreach from=$keys item=item}
                        <li>{$item['text']}</li>
                    {/foreach}
                </ul>
            </div>

            {ActiveForm assign='form' action='/ask/create'
                        options=['id' => 'registration-form', 'class' => 'registration-form ask-form' ]
                        enableAjaxValidation=true validationUrl='/ask/validate'}
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-1">
                        {$form->field( $ask, 'name' )->textInput([
                            'placeholder' => Yii::t('app', 'Name')
                        ])->label(false)}
                        {$form->field( $ask, 'phone')
                            ->widget(
                                'yii\widgets\MaskedInput',
                                $ask->getMaskedPhoneConfig([
                                    'options' => ['placeholder' => Yii::t('app', 'Phone')]
                                ])
                            )->label(false)}
                        <div class="form-group">
                            {Html::input('submit', 'submit', Yii::t('app', 'Send Ask') )}
                        </div>
                    </div>
                    <div class="col-sm-5">
                        {$form->field( $ask, 'sex' )->radioList([
                            1 => Yii::t('app', 'M'),
                            0 => Yii::t('app', 'Ж')
                        ])}
                        {$form->field( $ask, 'age' )->input('number')}
                    </div>
                </div>
            {/ActiveForm}
            <div class="registration-info">
                <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
                <p>Возрастные группы:<span>от 22 до 34</span><span class="age-old">от 35 и старше</span></p>
            </div>
        </article>
    </div>
</section>
