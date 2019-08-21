<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Delete Account</h2>
            </div>

            <div class="alert alert-danger mt-4 mb-4" role="alert">
                Are you sure that you want to remove this account and all the data attached?
            </div>


            <form data_id="_USER_DELETE"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/user/post"
                  method="post" class="form-post label-design">
                <? if ($object): ?>
                    <input type="hidden" id="uid" name="uid"
                           value="<?= (isset($object['uid']) ? $object['uid'] : '') ?>"/>
                <? endif ?>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="first_name" class="form-control" id="first_name"
                                   value="<?= (isset($object['p_first_name']) ? $object['p_first_name'] : '') ?>"
                                   disabled>
                            <label for="first_name" class="control-label">First name</label>
                        </div>
                        <div class="errors first_name_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="last_name" class="form-control" id="last_name"
                                   value="<?= (isset($object['p_last_name']) ? $object['p_last_name'] : '') ?>"
                                   disabled>
                            <label for="last_name" class="control-label">Last name</label>
                        </div>
                        <div class="errors last_name_errors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" id="email"
                                   value="<?= (isset($object['email']) ? $object['email'] : '') ?>" disabled>
                            <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="errors email_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" id="username"
                                   value="<?= (isset($object['username']) ? $object['username'] : '') ?>" disabled>
                            <label for="username" class="control-label">Username</label>
                        </div>
                        <div class="errors username_errors"></div>
                    </div>
                </div>


                <div class="grid-x grid-margin-x align-center">
                    <div class="cell">
                        <div class="message"></div>
                    </div>
                </div>

                <div class="form-group row btn-container">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-12 text-md-center">
                        <button class="btn custom-btn btn-danger">
                            Yes. Delete this account
                        </button>
                    </div>
                </div>
            </form>

        </main>

    </div>
</div>