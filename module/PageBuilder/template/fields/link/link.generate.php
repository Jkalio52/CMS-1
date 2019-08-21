<div id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object json_object <?= $data['object'] ?>"
     json='<?= $json ?>'>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-edit"></div>
    <div temp_id="<?= $tempID ?>" object="<?= $data['object'] ?>" class="object-destroy"></div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <input temp_id="<?= $tempID ?>" type="text" class="form-control" id="object-name"
                       name="object-name"
                       placeholder="<?= $data['placeholder'] ?>" value="<?= $data['default_value'] ?>">
                <label for="object-name"><?= $data['name'] ?>
                    Title <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <input temp_id="<?= $tempID ?>" type="text" class="form-control" id="object-link"
                       name="object-link"
                       placeholder="<?= $data['placeholder'] ?>" value="<?= $data['default_value'] ?>">
                <label for="object-link"><?= $data['name'] ?> Href</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <select temp_id="<?= $tempID ?>" class="form-control" id="object-target" name="object-target">
                    <option value="_blank">_blank</option>
                    <option value="_self">_self</option>
                    <option value="_parent">_parent</option>
                    <option value="_top">_top</option>
                    <option value="framename">framename</option>
                </select>
                <label for="object-target"><?= $data['name'] ?> Target</label>
            </div>
        </div>
    </div>
</div>