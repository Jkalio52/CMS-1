<div class="widget content product_details">
    <div class="widget__container">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-5">
                    <div class="product_details__gallery">
                        <div id="gallery_test" class="swiper-container gallery-top gallery-slider-init">
                            <div class="swiper-wrapper">
                                <? if (!empty($image)): ?>
                                    <div class="swiper-slide">
                                        <img alt="<?= isset($title) ? $title : '' ?>" src="<?= fileSrc($image) ?>"/>
                                    </div>
                                <? endif ?>
                                <? if (!empty($gallery)): ?>
                                    <? foreach ($gallery as $item): ?>
                                        <div class="swiper-slide">
                                            <img alt="<?= $title ?>" src="<?= fileSrc($item['value']) ?>"/>
                                        </div>
                                    <? endforeach ?>
                                <? endif ?>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                        <div id="gallery_test_thumbs" class="swiper-container product_details__gallery__images">
                            <div class="swiper-wrapper">
                                <? if (!empty($image)): ?>
                                    <div class="swiper-slide">
                                        <div class="product_details__gallery__images__image">
                                            <img alt="<?= $title ?>" src="<?= fileSrc($image) ?>"/>
                                        </div>
                                    </div>
                                <? endif ?>
                                <? if (!empty($gallery)): ?>
                                    <? foreach ($gallery as $item): ?>
                                        <div class="swiper-slide">
                                            <div class="product_details__gallery__images__image">
                                                <img alt="<?= $title ?>" src="<?= fileSrc($item['value']) ?>"/>
                                            </div>
                                        </div>
                                    <? endforeach ?>
                                <? endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-7 mt-4 mt-md-0">
                    <div class="product_details__container">
                        <? if (!empty($title)): ?>
                            <h2 class="widget__title product_details__title">
                                <?= $title ?>
                            </h2>
                        <? endif ?>
                        <? if (!empty($price)): ?>
                            <h5 class="widget__price product_details__price mb-2">
                                <?= $price ?>
                            </h5>
                        <? endif ?>
                        <? if (!empty($text)): ?>
                            <div class="widget__text product_details__text">
                                <?= $text ?>
                            </div>
                        <? endif ?>
                        <? if (isset($button) && !empty($button['title'])): ?>
                            <div class="widget__button_group product_details__button_group">
                                <a href="<?= $button['href'] ?>" target="<?= $button['target'] ?>"
                                   class="btn btn-success transparent reverse"><?= $button['title'] ?></a>
                            </div>
                        <? endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>