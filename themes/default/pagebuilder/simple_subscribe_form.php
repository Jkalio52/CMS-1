<div class="widget cta cta__center text-md-center">
    <div class="container">
        <?
        switch ($columns):
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
        <div class="row justify-content-center">
            <div class="col-sm-12 <?= $columns ?> text-<?= isset($text_align) ? $text_align : '' ?>">
                <form action="<?= isset($form_action) ? $form_action : '' ?>"
                      method="post" id="<?= isset($form_id_name) ? $form_id_name : '' ?>"
                      name="<?= isset($form_id_name) ? $form_id_name : '' ?>" class="validate"
                      target="_blank" novalidate="">
                    <? if (!empty($headline)): ?>
                        <h5 class="widget__headline cta__center__headline">
                            <?= $headline ?>
                        </h5>
                    <? endif ?>
                    <? if (!empty($title)): ?>
                        <h2 class="widget__title cta__center__title">
                            <?= $title ?>
                        </h2>
                    <? endif ?>
                    <? if (!empty($text)): ?>
                        <div class="widget__text cta__center__text">
                            <?= $text ?>
                        </div>
                    <? endif ?>
                    <div class="widget__field_group cta__center__field_group">
                        <div class="input-group">
                            <input type="text" class="form-control"
                                   name="<?= isset($email_input_id_name) ? $email_input_id_name : '' ?>"
                                   id="<?= isset($email_input_id_name) ? $email_input_id_name : '' ?>" placeholder="">
                            <div class="input-group-append">
                                <button class="btn btn-success" type="submit" id="button-addon2">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>