<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>SMTP Settings</h2>
            </div>

            <form data_id="_SMTP_MANAGE"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/settings/post"
                  method="post" class="form-post label-design">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="object_hostname" class="form-control" id="object_hostname"
                                   value="<?= (isset($object['hostname']) ? $object['hostname'] : '') ?>">
                            <label for="object_hostname" class="control-label">Hostname</label>
                        </div>
                        <div class="errors hostname_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="number" name="object_port" class="form-control" id="object_port"
                                   value="<?= (isset($object['port']) ? $object['port'] : '') ?>">
                            <label for="object_port" class="control-label">Port</label>
                        </div>
                        <div class="errors port_errors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="object_username" class="form-control" id="object_username"
                                   value="<?= (isset($object['username']) ? $object['username'] : '') ?>">
                            <label for="object_username" class="control-label">Username</label>
                        </div>
                        <div class="errors username_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="object_password" class="form-control" id="object_password"
                                   value="<?= (isset($object['password']) ? $object['password'] : '') ?>">
                            <label for="object_password" class="control-label">Password</label>
                        </div>
                        <div class="errors password_errors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="object_noreply_name" class="form-control" id="object_noreply_name"
                                   value="<?= (isset($object['noreply_name']) ? $object['noreply_name'] : '') ?>">
                            <label for="object_noreply_name" class="control-label">Noreply Name</label>
                        </div>
                        <div class="errors noreply_name_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="object_noreply_email" class="form-control"
                                   id="object_noreply_email"
                                   value="<?= (isset($object['noreply_email']) ? $object['noreply_email'] : '') ?>">
                            <label for="object_noreply_email" class="control-label">Noreply Email</label>
                        </div>
                        <div class="errors noreply_email_errors"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="object_tls"
                                       name="object_tls"<? if ($object['tls']): ?> checked<? endif; ?>>
                                <label class="custom-control-label" for="object_tls">
                                    TLS
                                </label>
                            </div>
                        </div>
                        <div class="errors object_tls_errors"></div>
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