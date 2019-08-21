<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">

            <?= messages('mt-4 mb-4') ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Current Routes</h2>
            </div>

            <div class="object-filter-container text-md-right">
                <a class="object-filter" data-toggle="collapse" href="#object_filter" role="button"
                   aria-expanded="false" aria-controls="object_filter">
                    <span class="oi oi-audio-spectrum"></span> Route Filter
                </a>
            </div>

            <div class="collapse multi-collapse<?= _get('filter') ? ' show' : '' ?>" id="object_filter">
                <div class="object-search">
                    <form action="" method="get" class="label-design">
                        <input type="hidden" id="filter" name="filter" value="true"/>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="route" class="form-control" id="route"
                                           value="<?= _get('route') ?>">
                                    <label for="route" class="control-label">Route</label>
                                    <div class="errors route_errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row btn-container">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button class="btn btn-info">
                                    Filter
                                </button>
                                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/settings/routing"
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
                            <th scope="col">Route</th>
                            <th scope="col">Module</th>
                            <th scope="col">Namespace</th>
                            <th scope="col">Action</th>
                            <th scope="col">Type</th>
                            <th scope="col">Methods</th>
                        </tr>
                        </thead>
                        <tbody>

                        <? if (isset($objects)): ?>
                            <? foreach ($objects['_ITEMS'] as $ITEM): ?>
                                <tr>
                                    <td>
                                        <a target="_blank"
                                           href="<?= webLink($ITEM['route']) ?>"><?= $ITEM['route'] ?></a>
                                    </td>
                                    <td><?= $ITEM['module'] ?></td>
                                    <td><?= $ITEM['namespace'] ?></td>
                                    <td><?= $ITEM['action'] ?></td>
                                    <td><?= $ITEM['type'] ?></td>
                                    <td><?= $ITEM['methods'] ?></td>
                                </tr>
                            <? endforeach; ?>
                        <? endif; ?>

                        </tbody>
                    </table>
                <? else: ?>
                    <? if (_get('filter')): ?>
                        No results available.
                    <? else: ?>
                        There are no routes created.
                    <? endif ?>
                <? endif ?>

            </div>

            <? if (isset($objects)): ?><?= $objects['_HTML'] ?><? endif; ?>

        </main>
    </div>
</div>