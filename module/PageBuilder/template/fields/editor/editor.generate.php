<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>
    <div class="form-group">
        <textarea temp_id="<?= $tempID ?>" class="form-control editor" id="object-name" name="object-name"
                  placeholder="<?= $data['placeholder'] ?>"><?= $data['default_value'] ?></textarea>
        <label for="object-name"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>