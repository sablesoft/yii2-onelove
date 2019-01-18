{use class='common\models\Helper'}
<section class="FAQ" id="FAQ-section">
    <div class="landing-wrapper">
        <h2>Вопрос / ответ</h2>
        <div class="wrapper-FAQ">
            {$faq = Helper::getParams('faq')}
            {foreach from=$faq  key=i  item=item}
            <article class="items item-{$i + 1}">
                <h3>{$item['question']}</h3>
                <div class="answer">{$item['answer']}</div>
            </article>
            {/foreach}
        </div>
    </div>
</section>
