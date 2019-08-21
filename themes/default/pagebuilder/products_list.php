<? if (!empty($products_list)): ?>
    <div class="products_list widget">
        <div class="container">
            <div class="row">
                <? foreach ($products_list as $product):
                    switch ($product['columns']):
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
                    <div class="col-sm-12 <?= $columns ?> mb-3 mt-3">
                        <? if (!empty($product['image'])): ?>
                            <div class="widget__image products_list__image mb-4">
                                <img title="<?= $product['title'] ?>" src="<?= fileSrc($product['image']) ?>"/>
                            </div>
                        <? endif ?>
                        <? if (!empty($product['price'])): ?>
                            <h5 class="widget__price products_list__price mb-1">
                                <?= $product['price'] ?>
                            </h5>
                        <? endif ?>
                        <? if (!empty($product['title'])): ?>
                            <h2 class="widget__title products_list__title mb-2">
                                <?= $product['title'] ?>
                            </h2>
                        <? endif ?>
                        <? if (!empty($product['description'])): ?>
                            <div class="widget__text products_list__description">
                                <p><?= $product['description'] ?></p>
                            </div>
                        <? endif ?>
                        <? if (isset($product['button']) && !empty($product['button']['title'])): ?>
                            <div class="content__image_text__button_group mt-4">
                                <a href="<?= $product['button']['href'] ?>"
                                   target="<?= $product['button']['target'] ?>"
                                   class="btn btn-success transparent reverse"><?= $product['button']['title'] ?></a>
                            </div>
                        <? endif ?>
                    </div>
                <? endforeach ?>
            </div>
        </div>
    </div>
<? endif ?>