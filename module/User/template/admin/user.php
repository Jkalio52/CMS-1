<?php

use _MODULE\User;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <? if (isset($object)): ?>
                    <h2>Update user</h2>
                <? else: ?>
                    <h2>Add new user</h2>
                <? endif; ?>
            </div>

            <form data_id="<? if (isset($object)): ?>_USER_UPDATE<? else: ?>_USER_CREATE<? endif ?>"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/user/post"
                  method="post" class="form-post label-design">

                <input type="hidden" id="uid" name="uid"
                       value="<?= (isset($object['uid']) ? $object['uid'] : '') ?>"/>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="first_name" class="form-control" id="first_name"
                                   value="<?= (isset($object['p_first_name']) ? $object['p_first_name'] : '') ?>">
                            <label for="first_name" class="control-label">First name</label>
                        </div>
                        <div class="errors first_name_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="last_name" class="form-control" id="last_name"
                                   value="<?= (isset($object['p_last_name']) ? $object['p_last_name'] : '') ?>">
                            <label for="last_name" class="control-label">Last name</label>
                        </div>
                        <div class="errors last_name_errors"></div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" id="email"
                                   value="<?= (isset($object['email']) ? $object['email'] : '') ?>">
                            <label for="email" class="control-label">Email</label>
                        </div>
                        <div class="errors email_errors"></div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-6">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" id="username"
                                   value="<?= (isset($object['username']) ? $object['username'] : '') ?>">
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


                <? $roles = User::$roles; ?>
                <? if (!empty($roles)): ?>
                    <div class="form-group">
                        <? foreach ($roles as $key => $role): ?>
                            <div class="custom-control custom-checkbox">
                                <input group="roles"
                                       unique_id="<?= $key ?>"
                                       type="checkbox"
                                       class="custom-control-input multiple"
                                       id="role_<?= $key ?>"
                                       name="role_<?= $key ?>"<? if (isset($currentRoles)): if (in_array($key, $currentRoles)): ?> checked<? endif;endif; ?>>
                                <label class="custom-control-label"
                                       for="role_<?= $key ?>">
                                    <?= $role ?>
                                </label>
                            </div>
                        <? endforeach; ?>
                    </div>
                <? endif ?>


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