<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div id="<?= $tempID ?>" object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>"
     class="object json_object fields-group <?= $data['object'] ?>">
    <div class="row">
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <input type="text" class="form-control object-name" id="object_<?= $tempID ?>_<?= $uniqueId ?>"
                       name="object_<?= $tempID ?>_<?= $uniqueId ?>"
                       placeholder="<?= $data['placeholder'] ?>" value="<?= $data['default_value'] ?>">
                <label for="object_<?= $tempID ?>_<?= $uniqueId ?>"><?= $data['name'] ?>
                    Title <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <input type="text" class="form-control object-link" id="object-link_<?= $tempID ?>_<?= $uniqueId ?>"
                       name="object-link_<?= $tempID ?>_<?= $uniqueId ?>"
                       placeholder="<?= $data['placeholder'] ?>"
                       value="<?= (isset($data['default_value_link']) ? $data['default_value_link'] : '') ?>">
                <label for="object-link_<?= $tempID ?>_<?= $uniqueId ?>"><?= $data['name'] ?> Href</label>
            </div>
        </div>

        <div class="col-sm-12 col-md-4">
            <div class="form-group">
                <? $target = isset($data['default_value_target']) ? $data['default_value_target'] : '' ?>
                <select class="form-control" id="object-target_<?= $tempID ?>_<?= $uniqueId ?>"
                        name="object-target_<?= $tempID ?>_<?= $uniqueId ?>">
                    <option value="_self"<?= $target === '_self' ? ' selected' : '' ?>>_self</option>
                    <option value="_blank"<?= $target === '_blank' ? ' selected' : '' ?>>_blank</option>
                    <option value="_parent"<?= $target === '_parent' ? ' selected' : '' ?>>_parent</option>
                    <option value="_top"<?= $target === '_top' ? ' selected' : '' ?>>_top</option>
                    <option value="framename"<?= $target === 'framename' ? ' selected' : '' ?>>framename</option>
                </select>
                <label for="object-target_<?= $tempID ?>_<?= $uniqueId ?>"><?= $data['name'] ?> Target</label>
            </div>
        </div>
    </div>
</div>