<section class="guest-stories">
    <div class="landing-wrapper">
        <h2>Счастливые истории наших гостей</h2>
        <div class="arrow arrow-left">
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="51px" height="31px">
                <defs>
                    <filter id="Filter_8">
                        <feOffset in="SourceAlpha" dx="0" dy="6" />
                        <feGaussianBlur result="blurOut" stdDeviation="4" />
                        <feFlood flood-color="rgb(0, 0, 0)" result="floodOut" />
                        <feComposite operator="out" in="floodOut" in2="blurOut" result="compOut" />
                        <feComposite operator="in" in="compOut" in2="SourceAlpha" />
                        <feComponentTransfer><feFuncA type="linear" slope="0.16"/></feComponentTransfer>
                        <feBlend mode="multiply" in2="SourceGraphic" />
                    </filter>
                </defs>
                <g filter="url(#Filter_8)">
                    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                          d="M45.002,10.437 L24.026,10.437 L24.026,5.003 L5.002,15.502 L24.026,26.000 L24.026,20.566 L45.002,20.566 L45.002,10.437 Z"/>
                </g>
            </svg>
        </div>
        <div class="wrapper-stories" id="stories-section">
            {foreach from=$commentItems key=i item=comment}
            <article class="item-{$i}">
                <p class="story">{$comment['story']}</p>
                <h3 class="author">{$comment['author']}</h3>
            </article>
            {/foreach}
        </div>
        <div class="arrow arrow-right">
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    width="51px" height="32px">
                <defs>
                    <filter id="Filter_9">
                        <feOffset in="SourceAlpha" dx="0" dy="6" />
                        <feGaussianBlur result="blurOut" stdDeviation="4" />
                        <feFlood flood-color="rgb(0, 0, 0)" result="floodOut" />
                        <feComposite operator="out" in="floodOut" in2="blurOut" result="compOut" />
                        <feComposite operator="in" in="compOut" in2="SourceAlpha" />
                        <feComponentTransfer><feFuncA type="linear" slope="0.16"/></feComponentTransfer>
                        <feBlend mode="multiply" in2="SourceGraphic" />
                    </filter>

                </defs>
                <g filter="url(#Filter_9)">
                    <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                          d="M5.998,21.563 L26.974,21.563 L26.974,26.996 L45.998,16.498 L26.974,6.000 L26.974,11.434 L5.998,11.434 L5.998,21.563 Z"/>
                </g>
            </svg>
        </div>
    </div>
</section>
