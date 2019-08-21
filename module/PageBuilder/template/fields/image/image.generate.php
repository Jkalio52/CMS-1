<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>
    <div class="form-group">
        <div class="image-placeholder"></div>
        <label for="object-name"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>