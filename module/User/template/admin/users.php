<?php

use _WKNT\_TIME;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">

            <?= messages('mt-4 mb-4') ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Users List</h2>
            </div>

            <div class="object-filter-container text-md-right">
                <a class="object-filter" data-toggle="collapse" href="#object_filter" role="button"
                   aria-expanded="false" aria-controls="object_filter">
                    <span class="oi oi-audio-spectrum"></span> Users Filter
                </a>
            </div>

            <div class="collapse multi-collapse<?= _get('filter') ? ' show' : '' ?>" id="object_filter">
                <div class="object-search">
                    <form action="" method="get" class="label-design">
                        <input type="hidden" id="filter" name="filter" value="true"/>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                           value="<?= _get('first_name') ?>">
                                    <label for="first_name" class="control-label">First name</label>
                                    <div class="errors first_name_errors"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                           value="<?= _get('last_name') ?>">
                                    <label for="last_name" class="control-label">Last name</label>
                                    <div class="errors last_name_errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" id="email"
                                           value="<?= _get('email') ?>">
                                    <label for="email" class="control-label">Email</label>
                                </div>
                                <div class="errors email_errors"></div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" id="username"
                                           value="<?= _get('username') ?>">
                                    <label for="username" class="control-label">Username</label>
                                </div>
                                <div class="errors username_errors"></div>
                            </div>
                        </div>

                        <div class="form-group row btn-container">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button class="btn btn-info">
                                    Filter
                                </button>
                                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/users"
                                   class="btn custom-btn custom-btn btn-link">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <? if (isset($objects)): ?>
                        <? foreach ($objects['_ITEMS'] as $ITEM): ?>
                            <tr>
                                <td><?= $ITEM['username'] ?></td>
                                <td><?= $ITEM['p_first_name'] ?> <?= $ITEM['p_last_name'] ?></td>
                                <td><?= $ITEM['email'] ?></td>
                                <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $ITEM['date_created']]) ?></td>
                                <td class="object-option align-middle text-right">
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/users/edit/<?= $ITEM['uid'] ?>?page=<?= $objects['_CURRENT_PAGE'] ?>"
                                       class="custom-btn-icon btn-icon">
                                        <span class="oi oi-pencil"></span>
                                    </a>
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/users/delete/<?= $ITEM['uid'] ?>?page=<?= $objects['_CURRENT_PAGE'] ?>"
                                       class="custom-btn-icon btn-icon">
                                        <span class="oi oi-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                    <? endif; ?>

                    </tbody>
                </table>
            </div>

            <? if (isset($objects)): ?><?= $objects['_HTML'] ?><? endif; ?>

        </main>
    </div>
</div>