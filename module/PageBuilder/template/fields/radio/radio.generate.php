<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>
    <div class="form-group">
        <? if (!empty($data['values'])):$i = 0;
            foreach ($data['values'] as $key => $text):$i++; ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radio-option"
                           id="radio-option-<?= $key ?>"
                           value="1"<?= ($i == count($data['values']) ? ' checked' : '') ?>>
                    <label class="form-check-label radio-label" for="radio-option-<?= $key ?>"><?= $text ?></label>
                </div>
            <? endforeach;endif; ?>
        <label for="object-name"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>