<?php

use _WKNT\_TIME;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">

            <?= messages('mt-4 mb-4') ?>

            <? if (!empty($delete)): ?>
                <form data_id="_GROUP_DELETE"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/post"
                      method="post" class="form-post label-design mt-4">

                    <div class="alert alert-danger mt-4 mb-4" role="alert">
                        Are you sure that you want to remove <b><?= $delete['0']['pbg_name'] ?></b>?
                    </div>

                    <input type="hidden" id="pbid" name="pbid" class="object_id"
                           value="<?= (isset($delete['0']['pbid']) ? $delete['0']['pbid'] : '') ?>"/>

                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="message"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-md-center">
                            <button class="btn custom-btn btn-danger mr-5">
                                Yes
                            </button>
                            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder"
                               class="btn custom-btn btn-info">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            <? endif ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Groups List</h2>
            </div>

            <div class="object-filter-container text-md-right">
                <a class="object-filter" data-toggle="collapse" href="#object_filter" role="button"
                   aria-expanded="false" aria-controls="object_filter">
                    <span class="oi oi-audio-spectrum"></span> Groups Filter
                </a>
                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/group">
                    New Group
                </a>
            </div>

            <div class="collapse multi-collapse<?= _get('filter') ? ' show' : '' ?>" id="object_filter">
                <div class="object-search">
                    <form action="" method="get" class="label-design">
                        <input type="hidden" id="filter" name="filter" value="true"/>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="group_name" class="form-control" id="group_name"
                                           value="<?= _get('group_name') ?>">
                                    <label for="group_name" class="control-label">Group Name</label>
                                    <div class="errors group_name_errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row btn-container">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button class="btn btn-info">
                                    Filter
                                </button>
                                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder"
                                   class="btn custom-btn custom-btn btn-link">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">

                <? if (!empty($objects['_ITEMS'])): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Group Title</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <? if (isset($objects)): ?>
                            <? foreach ($objects['_ITEMS'] as $ITEM): ?>
                                <tr>
                                    <td><?= $ITEM['pbg_name'] ?></td>
                                    <td><?= ($ITEM['pbg_status']) ? 'Published' : 'Draft' ?></td>
                                    <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $ITEM['pbg_date']]) ?></td>
                                    <td class="object-option align-middle text-right">
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/edit/<?= $ITEM['pbid'] ?>?page=<?= $objects['_CURRENT_PAGE'] ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-pencil"></span>
                                        </a>
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder?delete=<?= $ITEM['pbid'] ?>&p=<?= $objects['_CURRENT_PAGE'] ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-trash"></span>
                                        </a>
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/export/<?= $ITEM['pbid'] ?>"
                                           class="btn-icon custom-btn-icon d-none" target="_blank">
                                            <span class="oi oi-cloud-download"></span>
                                        </a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        <? endif; ?>

                        </tbody>
                    </table>
                <? else: ?>
                    <? if (_get('filter')): ?>
                        No results available.
                    <? else: ?>
                        There are no groups created.
                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/group">
                            Create your first group</a>.
                    <? endif ?>
                <? endif ?>

            </div>

            <? if (isset($objects)): ?><?= $objects['_HTML'] ?><? endif; ?>

        </main>
    </div>
</div>