<?php

use _MODULE\Dashboard;

?>
<nav class="sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item<?= (isset($menu) ? ($menu == 'dashboard' ? ' active' : '') : '') ?>">
                <a class="nav-link"
                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= Dashboard::dashboardLink() ?>">
                    <span class="oi oi-home"></span><span class="text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item<?= (isset($menu) ? ($menu == 'user' ? ' active' : '') : '') ?>">
                <a class="nav-link"
                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user">
                    <span class="oi oi-person"></span><span class="text">Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"
                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user/logout">
                    <span class="oi oi-account-logout"></span><span class="text">Logout</span>
                </a>
            </li>
        </ul>
        <?= Dashboard\_ADMINISTRATOR::menu(); ?>
    </div>
</nav>