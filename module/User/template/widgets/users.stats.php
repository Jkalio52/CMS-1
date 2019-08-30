<div class="col-6 col-sm-6 col-md-4 col-lg-3 text-center">
    <a href="<?= webLink('admin/users') ?>" class="dashboard__widget">
        <div class="dashboard__widget__icon">
            <span class="oi oi-person"></span>
        </div>
        <div class="dashboard__widget__count">
            <?= $count ?> <span>user<?= $count == 1 ? '' : 's' ?></span>
        </div>
    </a>
</div>
