<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <? if (isset($object)): ?>
                    <h2>Update category</h2>
                <? else: ?>
                    <h2>Add new category</h2>
                <? endif; ?>
            </div>

            <form data_id="<? if (isset($object)): ?>_BLOG_CATEGORY_UPDATE<? else: ?>_BLOG_CATEGORY_CREATE<? endif ?>"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/post"
                  method="post" class="form-post label-design">

                <input type="hidden" id="bcid" name="bcid" class="object_id"
                       value="<?= (isset($object['bcid']) ? $object['bcid'] : '') ?>"/>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="post-details">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input slug="object_slug" type="text" name="object_name"
                                               class="form-control document_title" id="object_name"
                                               value="<?= (isset($object['bc_title']) ? $object['bc_title'] : '') ?>">
                                        <label for="object_name" class="control-label">Category name</label>
                                    </div>
                                    <div class="errors object_name_errors"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="object_slug" class="form-control document_slug"
                                               id="object_slug"
                                               value="<?= (isset($object['bc_slug']) ? $object['bc_slug'] : '') ?>">
                                        <label for="object_slug" class="control-label">Category slug</label>
                                    </div>
                                    <div class="errors object_slug_errors"></div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12 col-mg-12 col-lg-12">
                                    <div class="form-group">
                                        <textarea name="object_body" class="form-control editor"
                                                  id="object_body"><?= (isset($object['bc_body']) ? $object['bc_body'] : '') ?></textarea>
                                        <label for="object_body" class="control-label">Body</label>
                                    </div>
                                    <div class="errors object_body_errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4">

                        <div class="post-settings">
                            <div class="row">

                                <div class="col-sm-12 col-md-6 col-lg-12 order-0 order-lg-0">
                                    <div class="form-group">
                                        <select id="object_template" name="object_template" class="form-control">
                                            <option value="">Select template</option>
                                            <? if (!empty($objectTemplates)): ?>
                                                <? foreach ($objectTemplates as $key => $value): ?>
                                                    <option value="<?= $value ?>"<?= ($value == (isset($object['bcd_template']) ? $object['bcd_template'] : '') ? ' selected' : '') ?>><?= $key ?></option>
                                                <? endforeach; ?>
                                            <? endif; ?>
                                        </select>
                                        <label for="object_template" class="control-label">Template</label>
                                    </div>
                                    <div class="errors object_template_errors"></div>
                                </div>


                                <div class="col-sm-12 col-md-6 col-lg-12 order-1 order-lg-1">
                                    <div class="form-group">
                                        <select id="object_parent" name="object_parent" class="form-control">
                                            <option value=""<?= ((isset($object['bcd_parent']) ? $object['bcd_parent'] : '') == '' ? ' selected' : '') ?>>
                                                Select Parent
                                            </option>
                                            <? if (!empty($categories)): ?>
                                                <? foreach ($categories as $category): ?>
                                                    <option value="<?= $category['bcid'] ?>"<? if (isset($object['bcd_parent']) && $object['bcd_parent'] == $category['bcid']): ?> selected<? endif; ?>><?= $category['bc_title'] ?></option>
                                                <? endforeach; ?>
                                            <? endif ?>
                                        </select>
                                        <label for="object_parent" class="control-label">Parent</label>
                                    </div>
                                    <div class="errors object_parent_errors"></div>
                                </div>


                                <div class="col-sm-12 col-md-12 col-lg-12 order-1 order-lg-3">
                                    <div class="form-group">

                                        <div class="file-load">
                                            <input type="hidden" name="cover" class="form-control"
                                                   id="cover"
                                                   value="<?= (isset($object['bc_cover']) ? $object['bc_cover'] : '') ?>">

                                            <div class="picture-select picture-preview">
                                                <div class="clear pictureClear">x</div>
                                                <div class="image-container">
                                                    <? if (isset($object['bc_cover'])):if (!empty($object['bc_cover'])): ?>
                                                        <img src="<?= fileSrc($object['bc_cover']) ?>"/>
                                                    <? endif;endif ?>
                                                </div>

                                                <div class="file-select select-image" object="blog" save_to="cover"
                                                     group="images">
                                                    select image
                                                </div>
                                            </div>
                                        </div>

                                        <label for="cover" class="control-label">Cover Image</label>
                                    </div>

                                    <div class="errors cover_errors"></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12 order-2 order-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="object_seo_name" class="form-control"
                                               id="object_seo_name"
                                               value="<?= (isset($object['bcd_seo_title']) ? $object['bcd_seo_title'] : '') ?>">
                                        <label for="object_seo_name" class="control-label">SEO Name</label>
                                    </div>
                                    <div class="errors object_seo_name_errors"></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12 order-3 order-lg-5">
                                    <div class="form-group">
                                    <textarea rows="4" name="object_seo_description" class="form-control"
                                              id="object_seo_description"><?= (isset($object['bcd_seo_description']) ? $object['bcd_seo_description'] : '') ?></textarea>
                                        <label for="object_seo_description" class="control-label">SEO
                                            Description</label>
                                    </div>
                                    <div class="errors object_seo_description_errors"></div>
                                </div>


                                <div class="col-sm-12 col-md-12 col-lg-12 order-5 order-lg-2">
                                    <div class="form-group">
                                        <select id="object_status" name="object_status" class="form-control">
                                            <option value=""<?= ((isset($object['bcd_status']) ? $object['bcd_status'] : '') == '' ? ' selected' : '') ?>>
                                                Select Status
                                            </option>
                                            <option value="DRAFT"<?= ((isset($object['bcd_status']) ? $object['bcd_status'] : '') == 'DRAFT' ? ' selected' : '') ?>>
                                                Draft
                                            </option>
                                            <option value="PUBLISHED"<?= ((isset($object['bcd_status']) ? $object['bcd_status'] : '') == 'PUBLISHED' ? ' selected' : '') ?>>
                                                Published
                                            </option>
                                        </select>
                                        <label for="object_status" class="control-label">Status</label>
                                    </div>
                                    <div class="errors object_status_errors"></div>
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