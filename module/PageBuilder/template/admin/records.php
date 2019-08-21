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
                <form data_id="_RECORD_DELETE"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/page-builder/post"
                      method="post" class="form-post label-design mt-4">

                    <div class="alert alert-danger mt-4 mb-4" role="alert">
                        Are you sure that you want to remove this record?
                    </div>

                    <input type="hidden" id="pbfd_id" name="pbfd_id" class="form_id"
                           value="<?= (isset($delete['0']['pbfd_id']) ? $delete['0']['pbfd_id'] : '') ?>"/>

                    <input type="hidden" id="formId" name="formId" class="form_id"
                           value="<?= $formId ?>"/>

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
                            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/forms/records/<?= $formId ?>"
                               class="btn custom-btn btn-info">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            <? endif ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Data Records</h2>
            </div>

            <div class="table-responsive">
                <? if (!empty($objects['_ITEMS'])): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <? foreach ($headingsList as $heading): ?>
                                <th scope="col"><?= $heading ?></th>
                            <? endforeach; ?>
                            <th scope="col">Submited Date</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <? if (isset($objects)): ?>
                            <? foreach ($objects['_ITEMS'] as $ITEM): ?>
                                <tr>
                                    <? foreach ($ITEM as $key => $data): ?>
                                        <? if ($key === 'created'): ?>
                                            <td>
                                                <?= _TIME::_DATE_TIME_CONVERT(['_DATE' => $data, '_MODE' => '_FULL_DATE']) ?>
                                            </td>
                                        <? elseif ($key === 'record_id'): ?>
                                            <td class="object-option align-middle text-right">
                                                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/forms/records/<?= $formId ?>?delete=<?= $data ?>&p=<?= $objects['_CURRENT_PAGE'] ?>"
                                                   class="btn-icon custom-btn-icon">
                                                    <span class="oi oi-trash"></span>
                                                </a>
                                            </td>
                                        <? else: ?>
                                            <td>
                                                <?= $data ?>
                                            </td>
                                        <? endif ?>
                                    <? endforeach ?>
                                </tr>
                            <? endforeach; ?>
                        <? endif; ?>

                        </tbody>
                    </table>
                <? else: ?>
                    No results available.
                <? endif ?>
            </div>
            <? if (isset($objects)): ?><?= $objects['_HTML'] ?><? endif; ?>
        </main>
    </div>
</div>