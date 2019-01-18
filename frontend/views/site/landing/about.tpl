{use class='common\models\Helper'}
<section class="instruction" id="instruction-section">
    <div class="landing-wrapper">
        <h2>Как проходят встречи в нашем клубе знакомств?</h2>
        <div class="items">
            {$about = Helper::getParams('about')}
            {foreach from=$about key=i item=item}
                <article class="item-{$i + 1}">
                    <div class="image">
                        <img src="{$item['image']}" alt="Icon">
                    </div>
                    <div class="caption">
                        <h3>{$item['title']}</h3>
                        <p>{$item['text']}</p>
                    </div>
                </article>
                {if !empty( $item['arrow'] )}
                    <div class="arrow-next">
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="116px" height="65px">
                            <defs>
                                <filter id="Filter_0">
                                    <feOffset in="SourceAlpha" dx="0" dy="6" />
                                    <feGaussianBlur result="blurOut" stdDeviation="8" />
                                    <feFlood flood-color="rgb(0, 0, 0)" result="floodOut" />
                                    <feComposite operator="out" in="floodOut" in2="blurOut" result="compOut" />
                                    <feComposite operator="in" in="compOut" in2="SourceAlpha" />
                                    <feComponentTransfer><feFuncA type="linear" slope="0.4"/></feComponentTransfer>
                                    <feBlend mode="multiply" in2="SourceGraphic" />
                                </filter>

                            </defs>
                            <g filter="url(#Filter_0)">
                                <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                                      d="M5.378,45.604 L60.358,45.604 L60.358,59.585 L110.223,32.573 L60.358,5.562 L60.358,19.543 L5.378,19.543 L5.378,45.604 Z"/>
                            </g>
                        </svg>
                    </div>
                {/if}
            {/foreach}
        </div>
    </div>
</section>