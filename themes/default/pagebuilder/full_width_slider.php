<div class="widget content full_width_slider">
    <? if (!empty($full_width_slider)): ?>
        <div id="slider__<?= isset($pbd_id) ? $pbd_id : '' ?>" class="swiper-container slider-init" data-fade="true">
            <div class="full_width_slider__wrapper swiper-wrapper">
                <? foreach ($full_width_slider as $slide):
                    switch ($slide['columns']):
                        case 1:
                            $columns = 'col-md-4 col-lg-1 col-xl-1';
                            break;
                        case 2:
                            $columns = 'col-md-6 col-lg-2';
                            break;
                        case 3:
                            $columns = 'col-md-6 col-lg-3';
                            break;
                        case 4:
                            $columns = 'col-md-6 col-lg-4';
                            break;
                        case 5:
                            $columns = 'col-md-7 col-lg-5';
                            break;
                        case 6:
                            $columns = 'col-md-8 col-lg-6';
                            break;
                        case 7:
                            $columns = 'col-md-9 col-lg-7';
                            break;
                        case 8:
                            $columns = 'col-md-10 col-lg-8';
                            break;
                        case 9:
                            $columns = 'col-md-11 col-lg-9';
                            break;
                        case 10:
                            $columns = 'col-md-11 col-lg-10';
                            break;
                        case 11:
                            $columns = 'col-md-12 col-lg-11';
                            break;
                        case 12:
                            $columns = 'col-md-12 col-lg-12';
                            break;
                    endswitch; ?>
                    <div class="full_width_slider__slide swiper-slide"<? if (!empty($slide['image'])): ?>
                        style="background: url('<?= fileSrc($slide['image']) ?>')"<? endif ?>>
                        <div class="full_width_slider__overlay"></div>
                        <div class="container <?= isset($slide['text_align']) ? $slide['text_align'] : '' ?>">
                            <div class="row justify-content-<?= isset($slide['widget_position']) ? $slide['widget_position'] : '' ?> align-items-center">
                                <div class="col-sm-12 <?= $columns ?>">
                                    <? if (!empty($slide['headline'])): ?>
                                        <h5 class="widget__headline full_width_slider__headline mb-3">
                                            <?= $slide['headline'] ?>
                                        </h5>
                                    <? endif ?>
                                    <? if (!empty($slide['title'])): ?>
                                        <h2 class="widget__headline full_width_slider__title mb-3">
                                            <?= $slide['title'] ?>
                                        </h2>
                                    <? endif ?>
                                    <? if (!empty($slide['text'])): ?>
                                        <div class="widget__text full_width_slider__text">
                                            <?= $slide['text'] ?>
                                        </div>
                                    <? endif ?>
                                    <? if (isset($slide['button']) && !empty($slide['button']['title'])): ?>
                                        <div class="full_width_slider__group mt-4">
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
                <div class="full_width_slider__arrows">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <? endif ?>
</div>