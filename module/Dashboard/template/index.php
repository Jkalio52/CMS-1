<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">
        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>
        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Dashboard</h2>
            </div>
            <div class="shortcuts">
                Welcome to your dashboard.
            </div>
        </main>
    </div>
</div>