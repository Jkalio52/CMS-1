<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Profile Update</h2>
            </div>

            <form data_id="_USER_PROFILE"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user/post"
                  method="post" class="form-post label-design">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="first_name" class="form-control" id="first_name"
                                   value="<?= (isset($user['p_first_name']) ? $user['p_first_name'] : '') ?>">
                            <label for="first_name" class="control-label">First name</label>
                        </div>
                        <div class="errors first_name_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="last_name" class="form-control" id="last_name"
                                   value="<?= (isset($user['p_last_name']) ? $user['p_last_name'] : '') ?>">
                            <label for="last_name" class="control-label">Last name</label>
                        </div>
                        <div class="errors last_name_errors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" id="email"
                                   value="<?= (isset($user['email']) ? $user['email'] : '') ?>">
                            <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="errors email_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" id="username"
                                   value="<?= (isset($user['username']) ? $user['username'] : '') ?>">
                            <label for="username" class="control-label">Username</label>
                        </div>
                        <div class="errors username_errors"></div>
                    </div>
                </div>

                <div class="hide-field">
                    <input type="password" name="password_1" class="form-control" id="password_1">
                    <label for="password_1" class="control-label">Password</label>
                </div>

                <div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="password">
                        <label for="password" class="control-label">Password</label>
                    </div>
                    <div class="errors password_errors"></div>
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