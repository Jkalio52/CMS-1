<? if (!empty($tabs_style_slider)): ?>
    <div class="tabs_style_slider">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider__<?= isset($pbd_id) ? $pbd_id : '' ?>" class="swiper-container slider-init">
                        <div class="swiper-wrapper">

                            <? foreach ($tabs_style_slider as $slide): ?>

                                <div class="swiper-slide">
                                    <div class="row align-items-center">
                                        <div class="col-sm-12 col-md-12 col-lg-6 <?= ($slide['image_location'] === 'left' ? 'order-1' : 'order-1 order-lg-2') ?>">
                                            <div class="slider-widget-image mb-3 mb-lg-0">
                                                <? if (!empty($slide['image'])): ?>
                                                    <img alt="<?= $slide['title'] ?>"
                                                         src="<?= fileSrc($slide['image']) ?>"><? endif ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-md-12 col-lg-6 <?= ($slide['image_location'] === 'left' ? 'order-2' : 'order-1 order-lg-1') ?>">
                                            <div class="slider-widget-details">
                                                <h5 class="widget__headline tabs_style_slider__headline">
                                                    <?= $slide['headline'] ?>
                                                </h5>
                                                <h2 class="widget__title tabs_style_slider__title">
                                                    <?= $slide['title'] ?>
                                                </h2>
                                                <div class="tabs_style_slider__text">
                                                    <?= $slide['text'] ?>
                                                </div>
                                                <? if (isset($slide['button']) && !empty($slide['button']['title'])): ?>
                                                    <div class="tabs_style_slider__button_group">
                                                        <a href="<?= $slide['button']['href'] ?>"
                                                           target="<?= $slide['button']['target'] ?>"
                                                           class="btn btn-success transparent reverse"><?= $slide['button']['title'] ?></a>
                                                    </div>
                                                <? endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endforeach ?>

                        </div>
                        <div class="swiper-pagination d-lg-none"></div>

                        <div class="tabs_style_slider__tab_list d-none d-lg-block">
                            <div class="row">
                                <? $i = 0;
                                foreach ($tabs_style_slider as $slide): ?>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <h5 id="slide_action__<?= $i ?>" slide_index="<?= $i ?>"
                                            class="tabs_style_slider__tab_name slide_action <?= $i == 0 ? 'active' : '' ?>">
                                            <?= $slide['tab_name'] ?>
                                        </h5>
                                    </div>
                                    <? $i++;endforeach ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
<? endif ?>
