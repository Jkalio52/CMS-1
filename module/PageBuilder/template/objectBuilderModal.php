<div class="modal fade pageBuilderModal" id="pageBuilderObject" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageBuilderModalTitle">
                    <span class="page-builder-title">Page Builder</span>
                    <span class="current-element"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="widgets">
                    <div class="row no-gutters">
                        <? if (!empty($widgets)): ?>
                            <? foreach ($widgets as $key => $widget): ?>
                                <div class="col-sm-12 col-md-6 widget-container">
                                    <div object="<?= $key ?>" class="<?= $widget['class'] ?>">
                                        <?= $widget['name'] ?>
                                    </div>
                                </div>
                            <? endforeach; ?>
                        <? endif ?>
                    </div>
                </div>
                <div class="elements"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button action="insert" item="ITEM_TYPE" item_id="" type="button" class="btn btn-primary field-manage"
                        disabled>
                    Insert
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade pageBuilderModal" id="pageBuilderObjectEdit" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pageBuilderModalTitle">
                    <span class="page-builder-title">Object Update</span>
                    <span class="current-element"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="edit-element"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button action="update" item="ITEM_TYPE" item_id="" type="button" class="btn btn-primary field-manage">
                    Update
                </button>
            </div>
        </div>
    </div>
</div>