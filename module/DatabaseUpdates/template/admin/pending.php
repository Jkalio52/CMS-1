<?php

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">

            <?= messages('mt-4 mb-4') ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Pending Database Migrations</h2>
            </div>

            <div class="table-responsive">

                <? if (!empty($_PENDING)): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Module</th>
                            <th scope="col">Filename</th>
                            <th scope="col">Description</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <? if (isset($_PENDING)): ?>
                            <? foreach ($_PENDING as $_OBJECT): ?>
                                <tr>
                                    <td><?= $_OBJECT['module'] ?></td>
                                    <td><?= $_OBJECT['filename'] ?></td>
                                    <td><?= $_OBJECT['description'] ?></td>
                                    <td class="object-option align-middle text-right">
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/migrate/<?= $_OBJECT['module'] ?>/<?= $_OBJECT['filename'] ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-cloud-download"></span>
                                        </a>
                                    </td>
                                </tr>
                            <? endforeach; ?>
                        <? endif; ?>
                        </tbody>
                    </table>
                <? else: ?>
                    There are no pending updates.
                <? endif ?>
            </div>

        </main>
    </div>
</div>