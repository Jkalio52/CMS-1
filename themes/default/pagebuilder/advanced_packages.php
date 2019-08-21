<? if (!empty($advanced_packages)): ?>
    <div class="widget content advanced_packages">
        <div class="container">
            <div class="row">
                <? foreach ($advanced_packages as $widget):
                    switch ($widget['columns']):
                        case 1:
                            $columns = 'col-md-3 col-lg-1 col-xl-1';
                            break;
                        case 2:
                            $columns = 'col-md-4 col-lg-2';
                            break;
                        case 3:
                            $columns = 'col-md-4 col-lg-3';
                            break;
                        case 4:
                            $columns = 'col-md-6 col-lg-4';
                            break;
                        case 5:
                            $columns = 'col-md-5 col-lg-5';
                            break;
                        case 6:
                            $columns = 'col-md-6 col-lg-6';
                            break;
                        case 7:
                            $columns = 'col-md-7 col-lg-7';
                            break;
                        case 8:
                            $columns = 'col-md-8 col-lg-8';
                            break;
                        case 9:
                            $columns = 'col-md-9 col-lg-9';
                            break;
                        case 10:
                            $columns = 'col-md-10 col-lg-10';
                            break;
                        case 11:
                            $columns = 'col-md-11 col-lg-11';
                            break;
                        case 12:
                            $columns = 'col-md-12 col-lg-12';
                            break;
                    endswitch; ?>
                    <div class="col-sm-12 <?= $columns ?>">
                        <div class="widget__container advanced_packages__container text-<?= isset($widget['text_align']) ? $widget['text_align'] : '' ?>">
                            <? if (!empty($widget['image'])): ?>
                                <img class="mb-3" title="<?= $widget['title'] ?>"
                                     src="<?= fileSrc($widget['image']) ?>"/>
                            <? endif ?>
                            <? if (!empty($widget['title'])): ?>
                                <h2 class="widget__title advanced_packages__title mb-3">
                                    <?= $widget['title'] ?>
                                </h2>
                            <? endif ?>
                            <? if (!empty($widget['price'])): ?>
                                <h5 class="widget__price advanced_packages__headline mb-2">
                                    <?= $widget['price'] ?>
                                    <? if (!empty($widget['price_per'])): ?><span>
                                        / <?= $widget['price_per'] ?></span><? endif ?>
                                </h5>
                            <? endif ?>
                            <? if (!empty($widget['description'])): ?>
                                <div class="widget__text advanced_packages__text">
                                    <p><?= $widget['description'] ?></p>
                                </div>
                            <? endif ?>
                            <? if (isset($widget['button']) && !empty($widget['button']['title'])): ?>
                                <div class="widget__button_group advanced_packages__button_group">
                                    <a href="<?= $widget['button']['href'] ?>"
                                       target="<?= $widget['button']['target'] ?>"
                                       class="btn btn-success transparent reverse">
                                        <?= $widget['button']['title'] ?>
                                    </a>
                                </div>
                            <? endif ?>
                        </div>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    </div>
<? endif ?>