<?
/**
 * Pages Module
 * Default Template File
 *
 * Variables:
 * $object['page_title']
 * $object['page_body']
 */

use _WKNT\_SANITIZE; ?>
<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'header.php') ?>
<? endif ?>

    <div class="page">
        <div class="page--header">
            <?= pageBuilderLoad('page_header') ?>
        </div>

        <div class="page--body">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <?= _SANITIZE::textarea_decode(isset($object['page_body']) ? $object['page_body'] : '') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="page--footer">
            <?= pageBuilderLoad('page_footer') ?>
        </div>
    </div>

<? if (!isset($ignorePartials)): ?>
    <?= render('partials', 'footer.php') ?>
<? endif ?>