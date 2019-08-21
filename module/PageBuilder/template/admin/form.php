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
                        <h2>Update form</h2>
                    <? else: ?>
                        <h2>Add a new form</h2>
                    <? endif; ?>
                </div>

                <form data_id="<? if (isset($object)): ?>_FORM_UPDATE<? else: ?>_FORM_CREATE<? endif ?>"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/post"
                      method="post" class="form-post label-design">

                    <input type="hidden" id="pbf_id" name="pbf_id" class="object_id"
                           value="<?= (isset($object['pbf_id']) ? $object['pbf_id'] : '') ?>"/>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <div class="page-details">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input machine="form_machine_name" type="text"
                                                   name="form_name" class="form-control object_name" id="form_name"
                                                   value="<?= (isset($object['pbf_name']) ? $object['pbf_name'] : '') ?>">
                                            <label for="form_name" class="control-label">Form Name</label>
                                        </div>
                                        <div class="errors form_name_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input <?= (isset($object['pbf_machine_name']) && !empty($object['pbf_machine_name']) ? 'overwrite="false"' : '') ?>
                                                    type="text" name="form_machine_name"
                                                    class="form-control machine_name"
                                                    id="form_machine_name"
                                                    value="<?= (isset($object['pbf_machine_name']) ? $object['pbf_machine_name'] : '') ?>">
                                            <label for="form_machine_name" class="control-label">Form Machine
                                                Name</label>
                                        </div>
                                        <div class="errors form_machine_name_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea id="form_description" name="form_description"
                                                      class="form-control"><?= (isset($object['pbf_description']) ? $object['pbf_description'] : '') ?></textarea>
                                            <label for="form_description" class="control-label">
                                                Form Description
                                            </label>
                                        </div>
                                        <div class="errors form_description_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea id="form_message" name="form_message"
                                                      class="form-control"><?= (isset($object['pbf_message']) ? $object['pbf_message'] : '') ?></textarea>
                                            <label for="form_message" class="control-label">
                                                Thank you message
                                            </label>
                                        </div>
                                        <div class="errors form_message_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea id="form_emails" name="form_emails"
                                                      placeholder="Enter one by one separated by a comma"
                                                      class="form-control"><?= (isset($object['pbf_notification_emails']) ? $object['pbf_notification_emails'] : '') ?></textarea>
                                            <label for="form_emails" class="control-label">
                                                Notification Emails
                                            </label>
                                        </div>
                                        <div class="errors form_emails_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" name="form_button_name" class="form-control"
                                                   id="form_button_name"
                                                   value="<?= (isset($object['pbf_button_name']) ? $object['pbf_button_name'] : '') ?>">
                                            <label for="form_button_name" class="control-label">
                                                Submit Button Name
                                            </label>
                                        </div>
                                        <div class="errors form_button_name_errors"></div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="form_recaptcha"
                                                       name="form_recaptcha"<? if (isset($object['pbf_recaptcha']) && $object['pbf_recaptcha']): ?> checked<? endif; ?>>
                                                <label class="custom-control-label mt-0" for="form_recaptcha">
                                                    Use Recaptcha
                                                </label>
                                            </div>
                                        </div>
                                        <div class="errors form_recaptcha_errors"></div>
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
                                    <div class="col-sm-12 col-md-12 col-lg-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="object_status"
                                                       name="object_status"<? if (isset($object['pbf_status']) && $object['pbf_status']): ?> checked<? endif; ?>>
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
<?= PageBuilder::objectBuilderModal(false) ?>