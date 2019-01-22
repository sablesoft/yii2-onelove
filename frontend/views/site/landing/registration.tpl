{* @var $party Party *}
{use class='common\models\Helper'}
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
            <form id="registration-form" class="registration-form"
                  name="registrationTop" action="mail.php" method="post">
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
                <input type="tel" name="telephone"
                       placeholder="+375(__) ___-__-__" required>
                <label class="label-age">
                    <span>Возраст: </span>
                    <input type="text" name="age" placeholder="__" required>
                </label>
                <input type="submit" value="Записаться">
            </form>
            <div class="registration-info">
                <p>Ближайший вечер:<span>{$party->timeLabel}</span></p>
                <p>Возрастные группы:<span>от 22 до 34</span><span class="age-old">от 35 и старше</span></p>
            </div>
        </article>
    </div>
</section>