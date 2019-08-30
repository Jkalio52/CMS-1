<?php

use _MODULE\Dashboard;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row align-content-around align-content-center align-items-center">
        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>
        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <div class="admin-dashboard__index__top">
                <div class="row">
                    <?= Dashboard::availableWidgets('_user_dashboard_index_', 'top', 'user_dashboard') ?>
                </div>
            </div>
            <div class="admin-dashboard__index__bottom">
                <div class="row">
                    <?= Dashboard::availableWidgets('_user_dashboard_index_', 'bottom', 'user_dashboard') ?>
                </div>
            </div>
        </main>
    </div>
</div>