{* @var $party Party *}
{use class='common\models\Helper'}
<div id="landing">
    {registerCss}
    .FAQ ul>li {
        list-style-image: url('/landing/img/heart-ico15x15.png');
    }
    {/registerCss}
    <main>

    {$sections = Helper::getSettings('section', true )}

        {include '@frontend/views/site/landing/registration.tpl'}
        {include '@frontend/views/site/landing/about.tpl'}
        {include '@frontend/views/site/landing/reason.tpl'}

    {if !empty( $sections['gallery'] )}
        {include '@frontend/views/site/landing/gallery.tpl'}
    {/if}
        {include '@frontend/views/site/landing/statistics.tpl'}

    {if !empty( $sections['comments'] )}
        {include '@frontend/views/site/landing/comments.tpl'}
    {/if}

        {include '@frontend/views/site/landing/faq.tpl'}
    </main>
    {include '@frontend/views/site/landing/place.tpl'}
</div>
{$party->map}
