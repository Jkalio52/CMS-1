<?php

use _MODULE\PageBuilder;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

    <div class="container-fluid">
        <div class="row">

            <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <? if (isset($object)): ?>
                        <h2>Update widget</h2>
                    <? else: ?>
                        <h2>Add a new widget</h2>
                    <? endif; ?>
                </div>

                <form data_id="<? if (isset($object)): ?>_OBJECT_UPDATE<? else: ?>_OBJECT_CREATE<? endif ?>"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/post"
                      method="post" class="form-post label-design">

                    <input type="hidden" id="pbo_id" name="pbo_id" class="object_id"
                           value="<?= (isset($object['pbo_id']) ? $object['pbo_id'] : '') ?>"/>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="page-details">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input machine="widget_machine_name" type="text"
                                                   name="widget_name" class="form-control object_name" id="widget_name"
                                                   value="<?= (isset($object['pbo_name']) ? $object['pbo_name'] : '') ?>">
                                            <label for="widget_name" class="control-label">Widget Name</label>
                                        </div>
                                        <div class="errors widget_name_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input <?= (isset($object['pbo_machine_name']) && !empty($object['pbo_machine_name']) ? 'overwrite="false"' : '') ?>
                                                    type="text" name="widget_machine_name"
                                                    class="form-control machine_name"
                                                    id="widget_machine_name"
                                                    value="<?= (isset($object['pbo_machine_name']) ? $object['pbo_machine_name'] : '') ?>">
                                            <label for="widget_machine_name" class="control-label">Widget Machine
                                                Name</label>
                                        </div>
                                        <div class="errors widget_machine_name_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea id="widget_description" name="widget_description"
                                                      class="form-control"><?= (isset($object['pbo_description']) ? $object['pbo_description'] : '') ?></textarea>
                                            <label for="widget_description" class="control-label">
                                                Widget Description
                                            </label>
                                        </div>
                                        <div class="errors widget_description_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="page-builder-object">
                                            <div class="current-fields emptyDiv">
                                                <?= (isset($itemsHtml) ? $itemsHtml : '') ?>
                                            </div>

                                            <div class="button-group">
                                                <div class="btn custom-btn btn-info page-builder-modal-action">
                                                    Add Field
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <select name="group" class="form-control" id="group">
                                                <option value="">Select group</option>
                                                <? if (!empty($objectsList)): ?>
                                                    <? foreach ($objectsList as $item): ?>
                                                        <option value="<?= $item['pbid'] ?>"<?= isset($object['pbo_pbid']) ? $object['pbo_pbid'] === $item['pbid'] ? ' selected' : '' : '' ?>><?= $item['pbg_name'] ?></option>
                                                    <? endforeach ?>
                                                <? endif ?>
                                            </select>
                                            <label for="group" class="control-label">Group</label>
                                        </div>
                                        <div class="errors group_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group mb-0">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="object_repeater"
                                                       name="object_repeater"<? if (isset($object['pbo_repeater']) && $object['pbo_repeater']): ?> checked<? endif; ?>>
                                                <label class="custom-control-label" for="object_repeater">
                                                    Allow this widget to be repeated
                                                </label>
                                            </div>
                                        </div>
                                        <div class="errors object_status_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="object_status"
                                                       name="object_status"<? if (isset($object['pbo_status']) && $object['pbo_status']): ?> checked<? endif; ?>>
                                                <label class="custom-control-label mt-0" for="object_status">
                                                    Enabled
                                                </label>
                                            </div>
                                        </div>
                                        <div class="errors object_status_errors"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="message"></div>
                        </div>
                    </div>

                    <div class="form-group row btn-container">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button class="btn custom-btn btn-info">
                                Save
                            </button>
                        </div>
                    </div>

                </form>
            </main>

        </div>
    </div>
<?= PageBuilder::objectBuilderModal() ?>