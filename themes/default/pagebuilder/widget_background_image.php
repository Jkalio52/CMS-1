<? switch ($columns):
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
<div class="widget content widget_background_image <?= isset($text_align) ? $text_align : '' ?>"
     style="<? if (!empty($image)): ?>background:url('<?= fileSrc($image) ?>')<? endif ?>">
    <div class="container">
        <div class="row justify-content-<?= isset($widget_position) ? $widget_position : '' ?> align-items-center">
            <div class="col-sm-12 <?= $columns ?>">
                <div class="widget__container widget_background_image__container">
                    <? if (!empty($headline)): ?>
                        <h5 class="widget__headline widget_background_image__headline mb-3">
                            <?= $headline ?>
                        </h5>
                    <? endif ?>
                    <? if (!empty($title)): ?>
                        <h2 class="widget__title widget_background_image__title mb-3">
                            <?= $title ?>
                        </h2>
                    <? endif ?>
                    <? if (!empty($text)): ?>
                        <div class="widget__text widget_background_image__text">
                            <?= $text ?>
                        </div>
                    <? endif ?>
                    <? if (isset($button) && !empty($button['title'])): ?>
                        <div class="widget_background_image__group mt-4">
                            <a href="<?= $button['href'] ?>" target="<?= $button['target'] ?>"
                               class="btn btn-success transparent reverse"><?= $button['title'] ?></a>
                        </div>
                    <? endif ?>
                </div>
            </div>

        </div>
    </div>
    <div class="widget_background_image__overlay"></div>
</div>