<div class="objects">
    <div class="row no-gutters">
        <? if (!empty($objectsList)): ?>
            <? foreach ($objectsList as $object): ?>
                <div class="col-sm-12 col-md-6 widget-container">
                    <div object="<?= $object['pbo_machine_name'] ?>" object_id="<?= $object['pbo_id'] ?>"
                         class="widget <?= $object['pbo_machine_name'] ?>"><?= $object['pbo_name'] ?></div>
                </div>
            <? endforeach; ?>
        <? endif ?>
    </div>
</div>
