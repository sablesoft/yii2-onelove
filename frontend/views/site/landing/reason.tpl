{use class='common\models\Helper'}
<section class="instruction-description">
    <div class="landing-wrapper">
        <img src="/landing/img/cytats/background-cytata.png" alt="Фон">
        <h2>Почему стоит прийти</h2>
        {$reason = Helper::getParams('reason')}
        {foreach from=$reason key=i item=item}
        <div class="quote-{$i + 1}">
            <span>{$item['text']}</span>
        </div>
        {/foreach}
    </div>
</section>