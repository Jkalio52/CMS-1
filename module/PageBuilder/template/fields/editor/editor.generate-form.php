<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div id="<?= $tempID ?>" object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>"
     class="object json_object <?= $data['object'] ?>">
    <div class="form-group">
        <textarea class="form-control <?= (isset($options['empty_editor']) ? 'editor-object' : 'editor') ?>"
                  id="object_<?= $tempID ?>_<?= $uniqueId ?>_timestamp"
                  name="object_<?= $tempID ?>_<?= $uniqueId ?>_timestamp"
                  placeholder="<?= $data['placeholder'] ?>"><?= $data['default_value'] ?></textarea>
        <label for="object_<?= $tempID ?>_<?= $uniqueId ?>"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>