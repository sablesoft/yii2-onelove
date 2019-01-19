{use class='yii\bootstrap\Html'}
<div class="site-login">
    <h1>{$this->title}</h1>
    <p>{Yii::t('yii', 'Please fill out the following fields to login')}:</p>
    <div class="row">
        <div class="col-lg-5">
            {ActiveForm assign='form' id='login-form' action='/login' options=['class' => 'form-horizontal']}
                {$form->field($model, 'username')->textInput(['autofocus' => true])}
                {$form->field($model, 'password')->passwordInput()}
                {$form->field($model, 'rememberMe')->checkbox()}

                <div style="color:#999;margin:1em 0">
                    {Yii::t('yii',
                        'If you forgot your password you can {0}',
                        Html::a( Yii::t('yii', 'reset it'), ['site/request-password-reset'])
                    )}
                </div>

                <div class="form-group">
                    {Html::submitButton(
                        Yii::t('yii', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']
                    )}
                </div>
            {/ActiveForm}
        </div>
    </div>
</div>
