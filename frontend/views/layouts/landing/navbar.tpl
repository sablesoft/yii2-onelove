{use class='common\models\Helper'}
<img class="parallax" src="landing/img/section2.png" alt="Parallax">
<header>
    <div class="landing-wrapper">
        <div class="wrapper-navigation-menu">
            <div id="logo">
                <a class="logo-initial" href="#">
                    <img src="landing/img/logo.png" alt="Логотип">
                </a>
                <a class="logo-final" href="#">
                    <img src="landing/img/one-love-logo2.png" alt="Логотип">
                </a>
            </div>
            <nav>
                <i class="fas fa-bars hamburger"></i>
                <ul>
                    <li><a href="#instruction-section">О нас</a></li>
                    <li><a href="#photo-section">Фотогалерея</a></li>
                    <li><a href="#FAQ-section">Вопрос/Ответ</a></li>
                    <li><a href="#stories-section">Отзывы</a></li>
                </ul>
            </nav>
            <button type="button" class="invite-button">Получить приглашение</button>
            <button type="button" class="button-mob-contact"><i class="fas fa-phone-volume"></i></button>
            <div class="header-info">
                <span>{Helper::getParams('supportPhone')}</span>
                {$social = Helper::getParams('social')}
                {foreach from=$social key=key item=item}
                <a href="{$item['href']}"
                   class="{$key}-link"><i class="fab {$item['icon']}"></i>{$item['label']}</a>
                {/foreach}
                <div class="button-group">
                    <button id="button-back-call">Обратный звонок</button>
                </div>
            </div>
        </div>
    </div>
</header>