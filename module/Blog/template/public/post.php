<?
/**
 * Blog Module
 * Default Template File
 *
 * Variables:
 * $object['bp_title']
 * $object['bp_body']
 * $categories
 */

use _WKNT\_SANITIZE; ?>
<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'header.php') ?>
<? endif ?>

    <div class="blog post">
        <div class="post--header">
            <?= pageBuilderLoad('post_header') ?>
        </div>

        <div class="blog-breadcrumb mb-4">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-12 col-md-10">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>blog">Blog</a>
                                </li>
                                <? if (!empty($categories)): foreach ($categories as $category):if (!$category['bcd_parent']): ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>blog/<?= $category['bc_slug'] ?>"><?= $category['bc_title'] ?></a>
                                    </li>
                                <? endif; endforeach;endif; ?>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= $object['bp_title'] ?>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="post--body">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-12 col-md-10">
                        <?= _SANITIZE::textarea_decode(isset($object['bp_body']) ? $object['bp_body'] : '') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="post--footer">
            <?= pageBuilderLoad('post_footer') ?>
        </div>
    </div>

<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'footer.php') ?>
<? endif ?>