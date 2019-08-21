<div class="page-builder page-builder-widget">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-builder-group">
                <div id="<?= $group ?>" class="current-fields"><?= implode("", $widgets) ?></div>

                <div class="button-group">
                    <div group="#<?= $group ?>" class="btn custom-btn btn-info pagebuilder-add-widget">
                        Add Widget
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>