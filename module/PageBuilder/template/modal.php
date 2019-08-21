<div class="modal fade pageBuilderModal page-builder-widgets-add" id="pageBuilderObject" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageBuilderModalTitle">
                    <span class="page-builder-title"><span class="oi oi-action-undo"></span> Page Builder</span>
                    <span class="current-element"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="widgets">
                    <div class="row no-gutters">
                        <? if (!empty($objectsList)): ?>
                            <? foreach ($objectsList as $object): ?>
                                <div class="col-sm-12 col-md-6 widget-container">
                                    <div object="<?= $object['pbg_machine_name'] ?>" object_id="<?= $object['pbid'] ?>"
                                         class="widget <?= $object['pbg_machine_name'] ?>"><?= $object['pbg_name'] ?></div>
                                </div>
                            <? endforeach; ?>
                        <? endif ?>
                    </div>
                </div>
                <div class="elements"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button group="GROUP_ID" widget="WIDGET_ID" item="ITEM_ID" type="button"
                        class="btn btn-primary widget-manage"
                        disabled>
                    Insert
                </button>
            </div>
        </div>
    </div>
</div>