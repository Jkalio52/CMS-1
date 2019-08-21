<?php

use _MODULE\Blog\PublicBlog;
use _WKNT\_SANITIZE;

?>
<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'header.php') ?>
<? endif ?>
    <div class="blog">
        <div class="intro"
             style="background: url('<?= !empty($object['bc_cover']) ? fileSrc($object['bc_cover']) : '' ?>')">
            <div class="overflow"></div>
            <div class="intro-header">
                <div class="container">
                    <div class="row main-row justify-content-center align-items-center text-md-center">
                        <div class="col-sm-12 col-md-10 col-lg-9">
                            <div class="headline">
                                <h1 class="blog-title">
                                    <?= isset($object['bc_title']) ? $object['bc_title'] : '' ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="blog-breadcrumb mb-4">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-12 col-lg-10">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>blog">Blog</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= $object['bc_title'] ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <? if (!empty($object['bc_body'])): ?>
            <div class="blog-body">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-sm-12 col-lg-10">
                            <?= _SANITIZE::textarea_decode(isset($object['bc_body']) ? $object['bc_body'] : '') ?>
                        </div>
                    </div>
                </div>
            </div>
        <? endif ?>

        <div class="blog-articles">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <? if (empty($posts['_ITEMS'])): ?>
                        <div class="col-sm-12 text-md-center">
                            <div class="mt-5 mb-5">
                                <h5>There are no articles available</h5>
                            </div>
                        </div>
                    <? else: ?>
                        <div class="col-sm-12 col-lg-10">
                            <div class="row">
                                <? foreach ($posts['_ITEMS'] as $post): ?>
                                    <div class="col-sm-12 col-md-6 blog-article-widget">
                                        <a href="<?= webLink($post['route']) ?>" title="<?= $post['bp_title'] ?>"
                                           class="post">
                                            <div class="post-image mb-3">
                                                <? if (!empty($post['bp_cover'])): ?>
                                                    <img src="<?= fileSrc($post['bp_cover']) ?>"/>
                                                <? endif ?>
                                            </div>
                                            <? $categories = PublicBlog::postCategories($post['bpid']); ?>
                                            <? if (!empty($categories)): ?>
                                                <div class="post-categories">
                                                    <? foreach ($categories as $category): ?>
                                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= $category['route'] ?>"
                                                           title="<?= $category['bc_title'] ?>"
                                                           class="post-category"><?= $category['bc_title'] ?></a>
                                                    <? endforeach; ?>
                                                </div>
                                            <? endif ?>
                                            <div class="post-title">
                                                <a title="<?= $post['bp_title'] ?>"
                                                   href="<?= webLink($post['route']) ?>"><?= $post['bp_title'] ?></a>
                                            </div>
                                            <div class="post-text">
                                                <div class="span ml-auto mr-auto"><?= $post['bp_preview'] ?></div>
                                            </div>
                                        </a>
                                    </div>

                                <? endforeach ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="blog-pagination">
                                        <div class="pagination justify-content-center">
                                            <? if (isset($posts['_HTML'])): ?><?= $posts['_HTML'] ?><? endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? endif ?>
                </div>
            </div>
        </div>
    </div>
<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'footer.php') ?>
<? endif ?>