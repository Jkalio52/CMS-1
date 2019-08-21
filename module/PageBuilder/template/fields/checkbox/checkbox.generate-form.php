<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div id="<?= $tempID ?>" object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>"
     class="object json_object <?= $data['object'] ?>">
    <div class="form-group form-check">
        <input temp_id="<?= $tempID ?>" class="form-check-input form-control" type="checkbox" value="1"
               id="object_<?= $tempID ?>_<?= $uniqueId ?>"
               name="object_<?= $tempID ?>_<?= $uniqueId ?>"<?= isset($data['default_value']) ? $data['default_value'] ? ' checked' : '' : '' ?>>
        <label class="form-check-label" for="object_<?= $tempID ?>_<?= $uniqueId ?>">
            <?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?>
        </label>
    </div>
</div>