<div class="widget content testimonials_slider">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <? if (!empty($testimonials_slider)): ?>
                    <div id="slider__<?= isset($pbd_id) ? $pbd_id : '' ?>" class="swiper-container slider-init"
                         data-loop="true" data-autoplay="2000">
                        <div class="testimonials_slider__wrapper swiper-wrapper mb-3">
                            <? foreach ($testimonials_slider as $slide):
                                if (isset($slide['columns'])):
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
                                    endswitch; endif ?>
                                <div class="testimonials_slider__slide swiper-slide">
                                    <div class="container text-center">
                                        <div class="row justify-content-center align-items-center">
                                            <div class="col-sm-12 <?= isset($columns) ? $columns : '' ?>">
                                                <? if (!empty($slide['text'])): ?>
                                                    <div class="widget__text testimonials_slider__text mb-4">
                                                        <?= $slide['text'] ?>
                                                    </div>
                                                <? endif ?>
                                                <? if (!empty($slide['name'])): ?>
                                                    <h2 class="widget__headline testimonials_slider__title mb-2">
                                                        <?= $slide['name'] ?>
                                                    </h2>
                                                <? endif ?>
                                                <? if (!empty($slide['job_title'])): ?>
                                                    <h5 class="widget__headline testimonials_slider__headline mb-3">
                                                        <?= $slide['job_title'] ?>
                                                    </h5>
                                                <? endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <? endforeach ?>
                        </div>

                        <div class="swiper-pagination"></div>

                    </div>
                <? endif ?>
            </div>
        </div>
    </div>
</div>
