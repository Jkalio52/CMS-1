<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div id="<?= $tempID ?>" object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>"
     class="object json_object <?= $data['object'] ?>">
    <div class="form-group">
        <select temp_id="<?= $tempID ?>" class="form-control" id="object_<?= $tempID ?>_<?= $uniqueId ?>"
                name="object_<?= $tempID ?>_<?= $uniqueId ?>">
            <option value=""><?= $data['placeholder'] ?></option>
            <? if (!empty($data['values'])): ?>
                <? foreach ($data['values'] as $key => $value): ?>
                    <option value="<?= $key ?>"<?= $data['default_value'] == $key ? ' selected' : '' ?>><?= $value ?></option>
                <? endforeach ?>
            <? endif ?>
        </select>
        <label for="object-name_<?= $tempID ?>_<?= $uniqueId ?>"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>