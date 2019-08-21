<div class="widget content two_columns_iframe">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 align-self-center order-2<? if (isset($video_position)): if ($video_position === 'right'): ?> order-md-1<? endif;endif ?>">
                <div class="widget__container two_columns_iframe__container">
                    <? if (isset($headline) && !empty($headline)): ?>
                        <h5 class="widget__headline two_columns_iframe__headline">
                            <?= isset($headline) ? $headline : '' ?>
                        </h5>
                    <? endif ?>
                    <? if (isset($title) && !empty($title)): ?>
                        <h2 class="widget__title two_columns_iframe__title">
                            <?= $title ?>
                        </h2>
                    <? endif ?>
                    <? if (isset($text) && !empty($text)): ?>
                        <div class="widget__text two_columns_iframe__text">
                            <?= $text ?>
                        </div>
                    <? endif ?>
                    <div class="widget__button_group two_columns_iframe__button_group">
                        <? if (isset($button) && !empty($button['title'])): ?>
                            <a href="<?= $button['href'] ?>"
                               target="<?= $button['target'] ?>" class="btn btn-success transparent reverse">
                                <?= $button['title'] ?>
                            </a>
                        <? endif ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-6 order-1<? if ($video_position === 'right'): ?> order-md-2<? endif ?>">
                <? if (!empty($video_iframe)): ?>
                    <div class="two_columns_iframe__container">
                        <div class="widget__image full_width_iframe__wrapper">
                            <?= $video_iframe ?>
                        </div>
                    </div>
                <? endif ?>
            </div>
        </div>
    </div>
</div>