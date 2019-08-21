<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div id="<?= $tempID ?>" object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>"
     class="object json_object <?= $data['object'] ?>"'>
<div class="form-group">
    <? if (!empty($data['values'])):$i = 0;
        foreach ($data['values'] as $key => $text):$i++; ?>
            <div class="form-check">
                <? if (empty($data['default_value'])): ?>
                    <input class="form-check-input" type="radio" name="radio-option_<?= $tempID ?>"
                           id="radio-option_<?= $tempID ?>_<?= $uniqueId ?>-<?= $key ?>"
                           value="<?= $text ?>"<?= ($i == count($data['values']) ? ' checked' : '') ?>>
                <? else: ?>
                    <input class="form-check-input" type="radio" name="radio-option_<?= $tempID ?>"
                           id="radio-option_<?= $tempID ?>_<?= $uniqueId ?>-<?= $key ?>"
                           value="<?= $text ?>"<?= $data['default_value'] === $text ? ' checked' : '' ?>>
                <? endif ?>
                <label class="form-check-label radio-label"
                       for="radio-option_<?= $tempID ?>_<?= $uniqueId ?>-<?= $key ?>"><?= $text ?></label>
            </div>
        <? endforeach;endif; ?>
    <label for="radio-option_<?= $tempID ?>_<?= $uniqueId ?>"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
</div>
</div>