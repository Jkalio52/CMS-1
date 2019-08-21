<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div class="file-load object json_object <?= $data['object'] ?>" id="<?= $tempID ?>"
     object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>">
    <div class="form-group">
        <div class="file-object">
            <div class="gallery-object gallery-images">
                <?= isset($galleryItems) ? $galleryItems : '' ?>
            </div>
            <div class="file-select select-image" object="pagebuilder-image"
                 save_to="object_<?= $tempID ?>_<?= $uniqueId ?>"
                 display_to=".gallery-images" gallery="true" group="images"></div>
        </div>
        <label for="object_<?= $tempID ?>_<?= $uniqueId ?>"
               class="control-label"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>