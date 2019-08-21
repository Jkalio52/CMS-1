<div class="widget content content__image">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-6 col-lg-6 align-self-center order-1<? if (isset($reverse_order)): if ($reverse_order): ?> order-md-2 offset-lg-1<? else: ?><? endif;endif ?>">
                <div class="widget__container content__image__container">
                    <? if (isset($headline) && !empty($headline)): ?>
                        <h5 class="widget__headline content__image__headline">
                            <?= isset($headline) ? $headline : '' ?>
                        </h5>
                    <? endif ?>
                    <? if (isset($title) && !empty($title)): ?>
                        <h2 class="widget__title content__image__title">
                            <?= $title ?>
                        </h2>
                    <? endif ?>
                    <? if (isset($text) && !empty($text)): ?>
                        <div class="widget__text content__image__text">
                            <?= $text ?>
                        </div>
                    <? endif ?>
                    <div class="widget__button_group content__image__button_group">
                        <? if (isset($button) && !empty($button['title'])): ?>
                            <a href="<?= $button['href'] ?>"
                               target="<?= $button['target'] ?>" class="btn btn-success transparent reverse">
                                <?= $button['title'] ?>
                            </a>
                        <? endif ?>
                        <? if (isset($button_2) && !empty($button_2)): ?>
                            <a href="<?= $button_2['href'] ?>"
                               target="<?= $button_2['target'] ?>"
                               class="btn btn-primary transparent reverse">
                                <?= $button_2['title'] ?>
                            </a>
                        <? endif ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-5 order-2<? if (isset($reverse_order)): if ($reverse_order): ?> order-md-1<? else: ?> offset-lg-1<? endif;endif ?>">
                <? if (!empty($form_code)): ?>
                    <div class="widget__image content__image__image">
                        <?= formDisplay($form_code) ?>
                    </div>
                <? endif ?>
            </div>
        </div>
    </div>
</div>