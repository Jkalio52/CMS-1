<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>
    <div class="form-group">
        <input temp_id="<?= $tempID ?>" type="<?= $data['type'] ?>" class="form-control" id="object-name"
               name="object-name"
               placeholder="<?= $data['placeholder'] ?>" value="<?= $data['default_value'] ?>">
        <label for="object-name"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>