<?php

use _MODULE\Blog;
use _WKNT\_TIME;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">

        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>

        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">

            <?= messages('mt-4 mb-4') ?>

            <? if (!empty($delete)): ?>
                <form data_id="_BLOG_CATEGORY_DELETE"
                      action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/post"
                      method="post" class="form-post label-design mt-4">

                    <div class="alert alert-danger mt-4 mb-4" role="alert">
                        Are you sure that you want to remove <b><?= $delete['0']['bc_title'] ?></b>?
                    </div>

                    <input type="hidden" id="bcid" name="bcid" class="object_id"
                           value="<?= (isset($delete['0']['bcid']) ? $delete['0']['bcid'] : '') ?>"/>

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
                            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories"
                               class="btn custom-btn btn-info">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            <? endif ?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Categories List</h2>
            </div>

            <div class="object-filter-container text-md-right">
                <a class="object-filter" data-toggle="collapse" href="#object_filter" role="button"
                   aria-expanded="false" aria-controls="object_filter">
                    <span class="oi oi-audio-spectrum"></span> Categories Filter
                </a>
                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories/add">
                    <span class="oi oi-plus"></span> Add Category
                </a>
            </div>

            <div class="collapse multi-collapse<?= _get('filter') ? ' show' : '' ?>" id="object_filter">
                <div class="object-search">
                    <form action="" method="get" class="label-design">
                        <input type="hidden" id="filter" name="filter" value="true"/>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="category_name" class="form-control" id="category_name"
                                           value="<?= _get('category_name') ?>">
                                    <label for="category_name" class="control-label">Category Name</label>
                                    <div class="errors category_name_errors"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row btn-container">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button class="btn btn-info">
                                    Filter
                                </button>
                                <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories"
                                   class="btn custom-btn custom-btn btn-link">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">

                <? if (!empty($objects)): ?>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Category Title</th>
                            <th scope="col">Category Url</th>
                            <th scope="col">Status</th>
                            <th scope="col">Date Updated</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>

                        <? if (isset($objects)): ?>
                            <? foreach ($objects as $ITEM): ?>
                                <? if ($ITEM['bcd_parent'] === 0): ?>
                                    <tr class="category-row">
                                        <td><?= $ITEM['bc_title'] ?></td>
                                        <td><?= Blog::blogSlug() ?><?= $ITEM['bc_slug'] ?></td>
                                        <td><?= $ITEM['bcd_status'] ?></td>
                                        <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $ITEM['bcd_date_updated']]) ?></td>
                                        <td class="object-option align-middle text-right">
                                            <a target="_blank"
                                               href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= Blog::blogSlug() ?><?= $ITEM['bc_slug'] ?>"
                                               class="btn-icon custom-btn-icon">
                                                <span class="oi oi-eye"></span>
                                            </a>
                                            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories/edit/<?= $ITEM['bcid'] ?>"
                                               class="btn-icon custom-btn-icon">
                                                <span class="oi oi-pencil"></span>
                                            </a>
                                            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories?delete=<?= $ITEM['bcid'] ?>"
                                               class="btn-icon custom-btn-icon">
                                                <span class="oi oi-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                    <? foreach ($objects as $child): ?>
                                        <? if ($ITEM['bcid'] === $child['bcd_parent']): ?>
                                            <tr class="subcategory-row">
                                                <td><?= $child['bc_title'] ?></td>
                                                <td><?= Blog::blogSlug() ?><?= $child['bc_slug'] ?></td>
                                                <td><?= $child['bcd_status'] ?></td>
                                                <td><?= _TIME::_STRTOTIME_TO_DATE(['_DATE' => $child['bcd_date_updated']]) ?></td>
                                                <td class="object-option align-middle text-right">
                                                    <a target="_blank"
                                                       href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= Blog::blogSlug() ?><?= $child['bc_slug'] ?>"
                                                       class="btn-icon custom-btn-icon">
                                                        <span class="oi oi-eye"></span>
                                                    </a>
                                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories/edit/<?= $child['bcid'] ?>"
                                                       class="btn-icon custom-btn-icon">
                                                        <span class="oi oi-pencil"></span>
                                                    </a>
                                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories?delete=<?= $child['bcid'] ?>"
                                                       class="btn-icon custom-btn-icon">
                                                        <span class="oi oi-trash"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                <? endif; ?>
                            <? endforeach; ?>
                        <? endif; ?>

                        </tbody>
                    </table>
                <? else: ?>
                    <? if (_get('filter')): ?>
                        No results available.
                    <? else: ?>
                        There are no categories created.
                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>admin/blog/categories/add">
                            Create your first category</a>.
                    <? endif ?>
                <? endif ?>

            </div>

        </main>
    </div>
</div>