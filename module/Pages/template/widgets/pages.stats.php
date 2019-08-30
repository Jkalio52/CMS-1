<div class="col-6 col-sm-6 col-md-4 col-lg-3 text-center">
    <a href="<?= webLink('admin/pages') ?>" class="dashboard__widget">
        <div class="dashboard__widget__icon">
            <span class="oi oi-folder"></span>
        </div>
        <div class="dashboard__widget__count">
            <?= $count ?> <span>page<?= $count == 1 ? '' : 's' ?></span>
        </div>
    </a>
</div>
