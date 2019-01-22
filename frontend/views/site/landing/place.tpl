{use class='common\models\Helper'}
{$place = $party->place}
{$price = $party->getPrice( true )}
<footer>
    <div class="landing-wrapper">

        <article class="contact">
            <div class="wrapper">
                <h2>Место проведения и стоимость</h2>
                <div class="image"><img src="landing/img/article-address.png" alt="{$place->name}"></div>
                <div class="address">
                    <p class="address-title"><b>{$place->name}</b></p>
                    <address>({$place->address})</address>
                    {if $party->timeLabel}
                    <strong>{$party->timeLabel}</strong>
                    {/if}
                    <p><strong>Стоимость участия - <span>{$price->baseLabel}</span></strong></p>
                    <p><strong>Вы пришли не один, то для Вас и ваших друзей стоимость - <span>{$price->companyLabel}</span></strong></p>
                    <p><strong>А если Вы решили прийти к нам еще раз - </strong><span><b>{$price->repeatLabel}</b></span></p>
                </div>
            </div>
        </article>

        <article class="registration-description">
            <h3>Приходите! Удачное свидание неизбежно!</h3>
            <form id="registration-form-footer" class="registration-form"
                  name="registrationBottom" action="mail.php" method="post">
                <input type="text" name="name" placeholder="*Имя" required>
                <div class="registration-radio">
                    <span>Пол: </span>
                    <label>
                        <input type="radio" name="gend" value="Мужчина" checked>
                        <span> М</span>
                    </label>
                    <label>
                        <input type="radio" name="gend" value="Женщина">
                        <span> Ж</span>
                    </label>
                </div>
                <input type="tel" name="telephone" placeholder="+375(__) ___-__-__" required>
                <label class="label-age">
                    <span>Возраст: </span>
                    <input type="text" name="age" placeholder="__" required>
                </label>
                <input type="submit" value="Записаться">
            </form>
            <div class="registration-info">
                {if $party->timeLabel}
                <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
                {/if}
            </div>
        </article>
        <p class="quote"><b>«Кто ищет, тот всегда найдет!»</b></p>
    </div>

    <div class="background-photo">
        <i class="fas fa-times close"></i>
        <img src="landing/img/photo/photo1.jpg" alt="Photo">
    </div>

    <article class="registration-description-bottom">
        <i class="fas fa-times close"></i>
        <h2>Клуб знакомств <span>OneLove</span></h2>
        <form id="registration-form-bottom" class="registration-form"
              name="registrationPopup" action="mail.php" method="post">
            <input type="text" name="name" placeholder="*Имя" required>
            <div class="registration-radio">
                <span>Пол: </span>
                <label>
                    <input type="radio" name="gend" value="Мужчина" checked>
                    <span> М</span>
                </label>
                <label>
                    <input type="radio" name="gend" value="Женщина">
                    <span> Ж</span>
                </label>
            </div>
            <input type="tel" name="telephone" placeholder="+375(__) ___-__-__" required>
            <label class="label-age">
                <span>Возраст: </span>
                <input type="text" name="age" placeholder="__" required>
            </label>
            <input type="submit" value="Записаться">
        </form>
        <div class="registration-info">
            {if $party->timeLabel}
            <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
            {/if}
            <p>Придет:<span>{$party->membersLabel}</span></p>
        </div>
    </article>

    <article class="registration-back-call">
        <i class="fas fa-times close"></i>
        <h2>Клуб знакомств <span>OneLove</span></h2>
        <form id="registration-form-back-call" class="registration-form-back" name="registrationBackCall" action="mail.php" method="post">
            <input type="text" name="name" placeholder="*Имя" required>
            <input type="tel" name="telephone" placeholder="+375(__) ___-__-__" required>
            <input type="submit" value="Отправить">
        </form>
    </article>
</footer>
