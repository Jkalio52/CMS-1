<? use _WKNT\_TIME;

if (isset($objects)): ?>
    <div class="col-sm-12">
        <div class="dashboard__widget table__widget">
            <div class="table-responsive">
                <a href="<?= webLink('admin/pages') ?>" class="dashboard__widget__title">
                    <span class="oi oi-folder"></span> Pages
                </a>
                <? if (!empty($objects)): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Page Title</th>
                            <th scope="col">Page Url</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($objects as $ITEM): ?>
                            <tr>
                                <td><?= $ITEM['page_title'] ?></td>
                                <td><?= $ITEM['page_slug'] ?></td>
                                <td><?= $ITEM['pd_status'] ?></td>
                                <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $ITEM['pd_date_updated']]) ?></td>
                                <td class="object-option align-middle text-right">
                                    <a target="_blank"
                                       href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= $ITEM['page_slug'] ?>"
                                       class="btn-icon custom-btn-icon">
                                        <span class="oi oi-eye"></span>
                                    </a>
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/pages/edit/<?= $ITEM['pid'] ?>?page=<?= $objects['_CURRENT_PAGE'] ?>"
                                       class="btn-icon custom-btn-icon">
                                        <span class="oi oi-pencil"></span>
                                    </a>
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/pages?delete=<?= $ITEM['pid'] ?>&p=<?= $objects['_CURRENT_PAGE'] ?>"
                                       class="btn-icon custom-btn-icon">
                                        <span class="oi oi-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        <? endforeach; ?>

                        </tbody>
                    </table>
                <? else: ?>
                    <? if (_get('filter')): ?>
                        No results available.
                    <? else: ?>
                        There are no pages created.
                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/pages/add">
                            Create your first page</a>.
                    <? endif ?>
                <? endif ?>

            </div>
        </div>
    </div>
<? endif; ?>