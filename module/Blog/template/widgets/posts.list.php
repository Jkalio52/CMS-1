<? use _MODULE\Blog;
use _WKNT\_TIME;

if (isset($objects)): ?>
    <div class="col-sm-12">
        <div class="dashboard__widget table__widget">
            <div class="table-responsive">
                <a href="<?= webLink('admin/blog') ?>" class="dashboard__widget__title">
                    <span class="oi oi-text"></span> Posts
                </a>

                <? if (!empty($objects)): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Post Title</th>
                            <th scope="col">Post Url</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <? if (isset($objects)): ?>
                            <? foreach ($objects as $ITEM): ?>
                                <tr>
                                    <td><?= $ITEM['bp_title'] ?></td>
                                    <td><?= Blog::blogSlug() ?><?= $ITEM['bp_slug'] ?></td>
                                    <td><?= $ITEM['bpd_status'] ?></td>
                                    <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $ITEM['bpd_date_updated']]) ?></td>
                                    <td class="object-option align-middle text-right">
                                        <a target="_blank"
                                           href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= Blog::blogSlug() ?><?= $ITEM['bp_slug'] ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-eye"></span>
                                        </a>
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/edit-post/<?= $ITEM['bpid'] ?>"
                                           class="btn-icon custom-btn-icon">
                                            <span class="oi oi-pencil"></span>
                                        </a>
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog?delete=<?= $ITEM['bpid'] ?>"
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
                    There are no posts created.
                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/add-post">
                        Create your first post
                    </a>.
                <? endif ?>
            </div>
        </div>
    </div>
<? endif ?>