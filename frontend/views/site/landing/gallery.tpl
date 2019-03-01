{use class='onmotion\gallery\Gallery'}
{use class='onmotion\gallery\GalleryAsset'}
{use class='onmotion\gallery\OnmotionAsset'}
{GalleryAsset::register($this)|void}
{OnmotionAsset::register($this)|void}
{registerJs key='show' position='POS_READY'}
    jQuery('body').css('overflow', 'auto');
    jQuery('#preloader').hide();
{/registerJs}
<section class="photo" id="photo-section">
    <div class="landing-wrapper">
        <h2>{Yii::t('app/frontend', 'Our public gallery')}</h2>
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    {Gallery::widget([
                        'id' => 'gallery-links',
                        'items' => $galleryItems,
                        'pluginOptions' => [
                            'slideshowInterval' => 2000,
                            'transitionSpeed' => 200
                        ]
                    ])}
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>
</section>