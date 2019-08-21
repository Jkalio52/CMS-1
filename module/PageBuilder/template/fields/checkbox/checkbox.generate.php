<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>

    <div class="form-group form-check">
        <input temp_id="<?= $tempID ?>" class="form-check-input form-control" type="checkbox" value="1"
               id="object-name" name="object-name">
        <label class="form-check-label" for="object-name">
            <?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?>
        </label>
    </div>
</div>