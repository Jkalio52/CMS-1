<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>
    <div class="form-group">
        <select temp_id="<?= $tempID ?>" class="form-control" id="object-name"
                name="object-name">
            <option><?= $data['placeholder'] ?></option>
            <? if (!empty($data['values'])): ?>
                <? foreach ($data['values'] as $key => $value): ?>
                    <option value="<?= $key ?>"><?= $value ?></option>
                <? endforeach ?>
            <? endif ?>
        </select>
        <label for="object-name"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>