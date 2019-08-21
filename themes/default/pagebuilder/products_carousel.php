<? if (!empty($products_carousel)): ?>
    <div class="products_carousel_links widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider__<?= isset($pbd_id) ? $pbd_id : '' ?>"
                         class="products_carousel_links__container swiper-container slider-init" data-slidesPerView="3">
                        <div class="products_carousel_links__controller">
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                        <div class="swiper-wrapper products_carousel_links__wrapper mb-4">
                            <? foreach ($products_carousel as $slide): ?>
                                <div class="swiper-slide products_carousel_links__slide">
                                    <a title="<?= $slide['title'] ?>" href="<?= $slide['link'] ?>">
                                        <? if (!empty($slide['image'])): ?>
                                            <img class="mb-3" alt="<?= $slide['title'] ?>"
                                                 src="<?= fileSrc($slide['image']) ?>"/>
                                        <? endif; ?>
                                        <? if (!empty($slide['price'])): ?>
                                            <h5 class="widget__price products_carousel_links__price mb-1">
                                                <?= $slide['price'] ?>
                                            </h5>
                                        <? endif ?>
                                        <? if (!empty($slide['title'])): ?>
                                            <h2 class="widget__title products_carousel_links__title mb-2">
                                                <?= $slide['title'] ?>
                                            </h2>
                                        <? endif ?>
                                        <? if (!empty($slide['text'])): ?>
                                            <div class="widget__text products_carousel_links__text">
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
    </div>
<? endif ?>

