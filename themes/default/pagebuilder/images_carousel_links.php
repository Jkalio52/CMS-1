<div class="images_carousel_links">
    <? if (!empty($images_carousel_links)): ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider__<?= isset($pbd_id) ? $pbd_id : '' ?>"
                         class="images_carousel_links__container swiper-container slider-init"
                         data-slidesPerView="3">

                        <div class="images_carousel_links__controller">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper images_carousel_links__wrapper mb-4">
                            <? foreach ($images_carousel_links as $slide): ?>
                                <div class="swiper-slide images_carousel_links__slide">
                                    <a title="<?= $slide['title'] ?>" href="<?= $slide['link'] ?>">
                                        <? if (!empty($slide['image'])): ?>
                                            <img class="mb-3" alt="<?= $slide['title'] ?>"
                                                 src="<?= fileSrc($slide['image']) ?>"/>
                                        <? endif; ?>

                                        <? if (!empty($slide['title'])): ?>
                                            <h2 class="widget__title images_carousel_links__title mb-3">
                                                <?= $slide['title'] ?>
                                            </h2>
                                        <? endif ?>
                                        <? if (!empty($slide['text'])): ?>
                                            <div class="widget__text images_carousel_links__text mb-3">
                                                <p><?= $slide['text'] ?></p>
                                            </div>
                                        <? endif ?>
                                    </a>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endif ?>
</div>