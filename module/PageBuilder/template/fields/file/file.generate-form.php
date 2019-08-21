<? $uniqueId = time() . (isset($options['unique_id']) ? $options['unique_id'] : '') ?>
<div id="<?= $tempID ?>" class="file-load object json_object <?= $data['object'] ?>"
     object="<?= $data['object'] ?>"
     objectRequired="<?= isset($data['required']) ? $data['required'] ? 'true' : 'false' : 'false' ?>">
    <div class="form-group">
        <input type="hidden" class="form-control" id="object_<?= $tempID ?>_<?= $uniqueId ?>"
               name="object_<?= $tempID ?>_<?= $uniqueId ?>" value="<?= $data['default_value'] ?>">
        <div class="file-object">
            <div class="file-current clear"><?= $data['default_fileName'] ?> <?= empty($data['default_fileName']) ? '' : '(x)' ?></div>
            <div class="file-select type-file" object="pagebuilder-file"
                 save_to="object_<?= $tempID ?>_<?= $uniqueId ?>"
                 display_to=".file-current" group="files"></div>
        </div>
        <label for="object_<?= $tempID ?>_<?= $uniqueId ?>"
               class="control-label"><?= $data['name'] ?> <?= isset($data['required']) ? $data['required'] ? '*' : '' : '' ?></label>
    </div>
</div>