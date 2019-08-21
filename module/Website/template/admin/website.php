<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Website Settings</h2>
            </div>

            <form data_id="_SETTINGS_MANAGE"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/settings/post"
                  method="post" class="form-post label-design">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <input type="text" name="object_seo_name" class="form-control" id="object_seo_name"
                                   value="<?= (isset($object['sw_title']) ? $object['sw_title'] : '') ?>">
                            <label for="first_name" class="control-label">Website Name</label>
                        </div>
                        <div class="errors first_name_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                                    <textarea rows="4" name="object_seo_description" class="form-control"
                                              id="object_seo_description"><?= (isset($object['sw_description']) ? $object['sw_description'] : '') ?></textarea>
                            <label for="object_seo_description" class="control-label">SEO Description</label>
                        </div>
                        <div class="errors object_seo_description_errors"></div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <select id="object_front" name="object_front" class="form-control">
                                <option value="" selected="">
                                    Select Page
                                </option>
                                <? if (!empty($pages)): ?>
                                    <? foreach ($pages as $page): ?>
                                        <option value="<?= $page['pid'] ?>" <?= (isset($object['sw_front']) ? $object['sw_front'] == $page['pid'] ? ' selected' : '' : '') ?>><?= $page['page_title'] ?></option>
                                    <? endforeach;endif; ?>
                            </select>
                            <label for="object_front" class="control-label">Front Page</label>
                        </div>
                        <div class="errors object_front_errors"></div>
                    </div>
                </div>

                <div class="grid-x grid-margin-x align-center">
                    <div class="cell">
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