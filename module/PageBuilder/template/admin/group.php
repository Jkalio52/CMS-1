<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <? if (isset($object)): ?>
                    <h2>Update group</h2>
                <? else: ?>
                    <h2>Add a new group</h2>
                <? endif; ?>
            </div>

            <form data_id="<? if (isset($object)): ?>_GROUP_UPDATE<? else: ?>_GROUP_CREATE<? endif ?>"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/post"
                  method="post" class="form-post label-design">

                <input type="hidden" id="pbid" name="pbid" class="object_id"
                       value="<?= (isset($object['pbid']) ? $object['pbid'] : '') ?>"/>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="page-details">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input machine="machine_name" type="text" name="group_name"
                                               class="form-control object_name" id="group_name"
                                               value="<?= (isset($object['pbg_name']) ? $object['pbg_name'] : '') ?>">
                                        <label for="group_name" class="control-label">Group name</label>
                                    </div>
                                    <div class="errors group_name_errors"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input <?= (isset($object['pbg_machine_name']) ? 'overwrite="false"' : '') ?>
                                                type="text" name="machine_name" class="form-control machine_name"
                                                id="machine_name"
                                                value="<?= (isset($object['pbg_machine_name']) ? $object['pbg_machine_name'] : '') ?>">
                                        <label for="machine_name" class="control-label">Machine name</label>
                                    </div>
                                    <div class="errors machine_name_errors"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                    <textarea rows="4" name="object_description" class="form-control"
                                              id="object_description"><?= (isset($object['pbg_description']) ? $object['pbg_description'] : '') ?></textarea>
                                        <label for="object_description" class="control-label">
                                            Group Description
                                        </label>
                                    </div>
                                    <div class="errors object_description_errors"></div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="object_status"
                                                   name="object_status"<? if (isset($object['pbg_status']) && $object['pbg_status']): ?> checked<? endif; ?>>
                                            <label class="custom-control-label" for="object_status">
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
