<? use _WKNT\_TIME;

if (isset($objects)): ?>
    <div class="col-sm-12">
        <div class="dashboard__widget table__widget">
            <div class="table-responsive">
                <a href="<?= webLink('admin/users') ?>" class="dashboard__widget__title">
                    <span class="oi oi-person"></span> Users
                </a>
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
                    <? if (!empty($objects)): foreach ($objects as $ITEM): ?>
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
                    <? endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<? endif; ?>