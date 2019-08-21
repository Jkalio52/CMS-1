<div class="simple_gallery">
    <? if (!empty($images)): ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="simple_gallery__<?= isset($pbd_id) ? $pbd_id : '' ?>"
                         class="card-columns simple_gallery__images gallery-init">
                        <? foreach ($images as $image): if (!empty($image['value'])): ?>
                            <div class="simple_gallery__image">
                                <a href="<?= fileSrc($image['value']) ?>" title="">
                                    <img src="<?= fileSrc($image['value']) ?>"/></a>
                            </div>
                        <? endif;endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    <? endif ?>
</div>