<? use _WKNT\_TIME;

if (isset($objects)): ?>
    <div class="col-sm-12">
        <div class="dashboard__widget table__widget">
            <a href="<?= webLink('admin/files') ?>" class="dashboard__widget__title">
                <span class="oi oi-file"></span> Files
            </a>
            <div class="table-responsive">
                <? if (!empty($objects)): ?>
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
                        <? foreach ($objects as $ITEM): ?>
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
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/files?delete=<?= $ITEM['fid'] ?>"
                                       class="btn-icon custom-btn-icon">
                                        <span class="oi oi-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        <? endforeach; ?>
                        </tbody>
                    </table>
                <? else: ?>
                    There are no files.
                <? endif ?>
            </div>
        </div>
    </div>
<? endif; ?>