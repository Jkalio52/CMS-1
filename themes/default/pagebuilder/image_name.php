<? if (!empty($image_name)): ?>
    <div class="image_name_gallery">
        <? if (!empty($image_name)): ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="image_name_gallery__<?= isset($pbd_id) ? $pbd_id : '' ?>"
                             class="card-columns image_name_gallery__images gallery-init">
                            <? foreach ($image_name as $image): if (!empty($image['image'])): ?>
                                <div class="image_name_gallery__image">
                                    <a title="<?= $image['name'] ?>" href="<?= fileSrc($image['image']) ?>" title="">
                                        <img title="<?= $image['name'] ?>" src="<?= fileSrc($image['image']) ?>"/></a>
                                </div>
                            <? endif;endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <? endif ?>
    </div>
<? endif ?>