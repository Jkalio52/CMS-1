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
                        <h2>Update page</h2>
                    <? else: ?>
                        <h2>Add new page</h2>
                    <? endif; ?>
                </div>

                <form data_id="<? if (isset($object)): ?>_PAGE_UPDATE<? else: ?>_PAGE_CREATE<? endif ?>"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/pages/post"
                      method="post" class="form-post label-design">

                    <input type="hidden" id="pid" name="pid" class="object_id"
                           value="<?= (isset($object['pid']) ? $object['pid'] : '') ?>"/>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <div class="page-details">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input slug="page_slug" type="text" name="page_name"
                                                   class="form-control document_title" id="page_name"
                                                   value="<?= (isset($object['page_title']) ? $object['page_title'] : '') ?>">
                                            <label for="page_name" class="control-label">Page name</label>
                                        </div>
                                        <div class="errors page_name_errors"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" name="page_slug" class="form-control document_slug"
                                                   id="page_slug"
                                                   value="<?= (isset($object['page_slug']) ? $object['page_slug'] : '') ?>">
                                            <label for="page_slug" class="control-label">Page slug</label>
                                        </div>
                                        <div class="errors page_slug_errors"></div>
                                    </div>
                                </div>

                                <?= PageBuilder::widget(
                                    [
                                        'group' => 'page_header'
                                    ]
                                ) ?>

                                <div class="row">
                                    <div class="col-sm-12 col-mg-12 col-lg-12">
                                        <div class="form-group">
                                        <textarea name="page_body" class="form-control editor"
                                                  id="page_body"><?= (isset($object['page_body']) ? $object['page_body'] : '') ?></textarea>
                                            <label for="page_body" class="control-label">Body</label>
                                        </div>
                                        <div class="errors page_body_errors"></div>
                                    </div>
                                </div>

                                <?= PageBuilder::widget(
                                    [
                                        'group' => 'page_footer'
                                    ]
                                ) ?>

                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-4">

                            <div class="page-settings">
                                <div class="row">

                                    <div class="col-sm-12 col-md-12 col-lg-12 order-1 order-lg-3">
                                        <div class="form-group">
                                            <input type="text" name="page_seo_name" class="form-control"
                                                   id="page_seo_name"
                                                   value="<?= (isset($object['pd_seo_title']) ? $object['pd_seo_title'] : '') ?>">
                                            <label for="page_seo_name" class="control-label">SEO Name</label>
                                        </div>
                                        <div class="errors page_seo_name_errors"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-12 col-lg-12 order-2 order-lg-4">
                                        <div class="form-group">
                                    <textarea rows="4" name="page_seo_description" class="form-control"
                                              id="page_seo_description"><?= (isset($object['pd_seo_description']) ? $object['pd_seo_description'] : '') ?></textarea>
                                            <label for="page_seo_description" class="control-label">SEO
                                                Description</label>
                                        </div>
                                        <div class="errors page_seo_description_errors"></div>
                                    </div>


                                    <div class="col-sm-12 col-md-6 col-lg-12 order-3 order-lg-1">
                                        <div class="form-group">
                                            <select id="page_template" name="page_template" class="form-control">
                                                <option value="">Select template</option>
                                                <? if (!empty($pageTemplates)): ?>
                                                    <? foreach ($pageTemplates as $key => $value): ?>
                                                        <option value="<?= $value ?>"<?= ($value == (isset($object['pd_template']) ? $object['pd_template'] : '') ? ' selected' : '') ?>><?= $key ?></option>
                                                    <? endforeach; ?>
                                                <? endif; ?>
                                            </select>
                                            <label for="page_template" class="control-label">Template</label>
                                        </div>
                                        <div class="errors page_template_errors"></div>
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-12 order-4 order-lg-2">
                                        <div class="form-group">
                                            <select id="page_status" name="page_status" class="form-control">
                                                <option value=""<?= ((isset($object['pd_status']) ? $object['pd_status'] : '') == '' ? ' selected' : '') ?>>
                                                    Select Status
                                                </option>
                                                <option value="DRAFT"<?= ((isset($object['pd_status']) ? $object['pd_status'] : '') == 'DRAFT' ? ' selected' : '') ?>>
                                                    Draft
                                                </option>
                                                <option value="PUBLISHED"<?= ((isset($object['pd_status']) ? $object['pd_status'] : '') == 'PUBLISHED' ? ' selected' : '') ?>>
                                                    Published
                                                </option>
                                            </select>
                                            <label for="page_status" class="control-label">Status</label>
                                        </div>
                                        <div class="errors page_status_errors"></div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-8">
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
<?= PageBuilder::modal() ?>