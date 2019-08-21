<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Blog Settings</h2>
            </div>

            <form data_id="_BLOG_SETTINGS"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/post"
                  method="post" class="form-post label-design">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <div class="post-details">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <input type="text" name="object_name" class="form-control"
                                               id="object_name"
                                               value="<?= (isset($object['bs_name']) ? $object['bs_name'] : '') ?>">
                                        <label for="object_name" class="control-label">Blog Name</label>
                                    </div>
                                    <div class="errors object_name_errors"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-mg-12 col-lg-12">
                                    <div class="form-group">
                                        <textarea name="object_body" class="form-control editor"
                                                  id="object_body"><?= (isset($object['bs_body']) ? $object['bs_body'] : '') ?></textarea>
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

                                <div class="col-sm-12 col-md-12 col-lg-12 order-2 order-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="object_seo_name" class="form-control"
                                               id="object_seo_name"
                                               value="<?= (isset($object['bs_seo_name']) ? $object['bs_seo_name'] : '') ?>">
                                        <label for="object_seo_name" class="control-label">SEO Name</label>
                                    </div>
                                    <div class="errors object_seo_name_errors"></div>
                                </div>

                                <div class="col-sm-12 col-md-12 col-lg-12 order-3 order-lg-5">
                                    <div class="form-group">
                                    <textarea rows="4" name="object_seo_description" class="form-control"
                                              id="object_seo_description"><?= (isset($object['bs_seo_description']) ? $object['bs_seo_description'] : '') ?></textarea>
                                        <label for="object_seo_description" class="control-label">
                                            SEO Description
                                        </label>
                                    </div>
                                    <div class="errors object_seo_description_errors"></div>
                                </div>


                                <div class="col-sm-12 col-md-12 col-lg-12 order-1 order-lg-5">
                                    <div class="form-group">

                                        <div class="file-load">
                                            <input type="hidden" name="cover" class="form-control"
                                                   id="cover"
                                                   value="<?= (isset($object['bs_cover']) ? $object['bs_cover'] : '') ?>">

                                            <div class="picture-select picture-preview">
                                                <div class="clear pictureClear">x</div>
                                                <div class="image-container">
                                                    <? if (isset($object['bs_cover'])):if (!empty($object['bs_cover'])): ?>
                                                        <img src="<?= fileSrc($object['bs_cover']) ?>"/>
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