<form class="field-container label-design m-0">
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <input machine="page-builder-object-machine-name" type="text" class="form-control required object_name"
                       validation="input" id="page-builder-object-name" name="page-builder-object-name"
                       placeholder="Field Name" value="<?= isset($data['name']) ? $data['name'] : '' ?>">
                <label for="page-builder-object-name">Field Name</label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <input <?= (isset($data['machine_name']) && !empty($data['machine_name']) ? 'overwrite="false"' : '') ?>
                        type="text" class="form-control required machine_name" validation="input"
                        id="page-builder-object-machine-name" name="page-builder-object-machine-name"
                        placeholder="Field Name"
                        value="<?= isset($data['machine_name']) ? $data['machine_name'] : '' ?>">
                <label for="page-builder-object-machine-name">Machine Name</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <textarea rows="5" class="form-control" id="page-builder-object-values"
                          name="page-builder-object-values"
                          placeholder="Red&#x0a;Blue&#x0a;Green"><?= isset($data['object_values']) ? $data['object_values'] : '' ?></textarea>
                <label for="object-name">Radio Options</label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 mt-3">
            <div class="form-group">
                <div class="form-group form-check">
                    <input class="form-check-input form-control" validation="requried" type="checkbox" value="1"
                           id="page-builder-object-required"
                           name="page-builder-object-required" <?= isset($data['required']) ? $data['required'] ? 'checked' : '' : '' ?>>
                    <label class="form-check-label mt-1" for="page-builder-object-required">
                        This field is required
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>