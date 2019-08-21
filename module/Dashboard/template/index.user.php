<?php

use _WKNT\_HOOK;

?>
<?= selfRender('Dashboard', 'partials/top-navigation.php') ?>

<div class="container-fluid">
    <div class="row">
        <?= selfRender('Dashboard', 'partials/left-menu.php') ?>
        <main role="main" class="col-md-12 ml-sm-auto col-lg-12 dashboard-container">
            <? _HOOK::execute('user_dashboard_index'); ?>
        </main>
    </div>
</div>