{use class='common\models\Helper'}
<section class="photo" id="photo-section">
    <div class="landing-wrapper">
        <h2>Наша фотогалерея</h2>
        <div class="photo-items">
            {$gallery = Helper::getParams('gallery')}
            {foreach from=$gallery  key=i item=item}
            <div>
                <img src="{$item['image']}"
                     alt="{$item['alt']}"
                     class="item-{$i + 1}" />
            </div>
            {/foreach}
        </div>
    </div>
</section>