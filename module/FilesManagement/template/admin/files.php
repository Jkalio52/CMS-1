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
                <form data_id="_FILE_DELETE"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/files/post"
                      method="post" class="form-post label-design mt-4">

                    <div class="alert alert-danger mt-4 mb-4" role="alert">
                        Are you sure that you want to remove <b><?= $delete['0']['filename'] ?></b>?
                    </div>

                    <input type="hidden" id="fid" name="fid" class="object_id"
                           value="<?= (isset($delete['0']['fid']) ? $delete['0']['fid'] : '') ?>"/>

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
                            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/files"
                               class="btn custom-btn btn-info">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            <? endif ?>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Files List</h2>
            </div>
            <div class="object-filter-container text-md-right">
                <a class="object-filter" data-toggle="collapse" href="#object_filter" role="button"
                   aria-expanded="false" aria-controls="object_filter">
                    <span class="oi oi-audio-spectrum"></span> Files Filter
                </a>
            </div>
            <div class="collapse multi-collapse<?= _get('filter') ? ' show' : '' ?>" id="object_filter">
                <div class="object-search">
                    <form action="" method="get" class="label-design">
                        <input type="hidden" id="filter" name="filter" value="true"/>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="filename" class="form-control" id="filename"
                                           value="<?= _get('filename') ?>">
                                    <label for="filename" class="control-label">File Name</label>
                                    <div class="errors filename_errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row btn-container">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button class="btn btn-info">
                                    Filter
                                </button>
                                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/files"
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
                            <th scope="col">File Name</th>
                            <th scope="col">Group</th>
                            <th scope="col">Type</th>
                            <th scope="col">Uploaded Date</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <? if (isset($objects)): ?>
                            <? foreach ($objects['_ITEMS'] as $ITEM): ?>
                                <tr>
                                    <td><?= $ITEM['filename'] ?></td>
                                    <td><?= $ITEM['filegroup'] ?></td>
                                    <td><?= $ITEM['filetype'] ?></td>
                                    <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $ITEM['uploaded_date']]) ?></td>
                                    <td class="object-option align-middle text-right">
                                        <a target="_blank"
                                           href="<?= fileSrc($ITEM['location']) ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-eye"></span>
                                        </a>
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/files?delete=<?= $ITEM['fid'] ?>&p=<?= $objects['_CURRENT_PAGE'] ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-trash"></span>
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
                        There are no files.
                    <? endif ?>
                <? endif ?>
            </div>
            <? if (isset($objects)): ?><?= $objects['_HTML'] ?><? endif; ?>
        </main>
    </div>
</div>