<div id="<?= $container_id ?>" class="widget content form_widget page_builder__form">
    <div class="container">
        <div class="row justify-content-<?= $column_align ?>">
            <? switch ($columns):
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
                <div class="widget__container form_widget__container">
                    <?= formDisplay($form_code) ?>
                </div>
            </div>
        </div>
    </div>
</div>