{use class='common\models\Helper'}
{use class='common\models\Party'}
{$party = Party::findCurrent()}
{$map = $party->getMap()}
{$sections = Helper::getSettings('section', true )}
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
                    {if !empty( $sections['gallery'] )}
                    <li><a href="#photo-section">Фотогалерея</a></li>
                    {/if}
                    <li><a href="#FAQ-section">Вопрос/Ответ</a></li>
                    {if !empty( $sections['comments'])}
                    <li><a href="#stories-section">Отзывы</a></li>
                    {/if}
                    {if !empty( $map )}
                        <li><a href="#place">Место</a></li>
                    {/if}
                </ul>
            </nav>
            <button type="button" class="invite-button">Получить приглашение</button>
            <button type="button" class="button-mob-contact"><i class="fas fa-phone-volume"></i></button>
            <div class="header-info">
                <span>{$party->currentPhone}</span>
                {$messengers = Helper::getSettings('messenger', true )}
                {foreach from=$messengers item=messenger}
                <a href="{$messenger['href']}"
                   class="{$messenger['class']}-link">
                    <i class="fab {$messenger['icon']}"></i>{$messenger['label']}
                </a>
                {/foreach}
                <div class="button-group">
                    <button id="button-back-call">Обратный звонок</button>
                </div>
            </div>
        </div>
    </div>
</header>