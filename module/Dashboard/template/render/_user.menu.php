<? if (!empty($menuItems)): ?>
    <? foreach ($menuItems as $module): if (!empty($module)): ?>
        <? foreach ($module as $key => $item): if (array_intersect($roles, $item['roles'])): ?>
            <? if (isset($item['heading']) && $item['heading']): ?>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-3">
                    <div class="text"><?= $item['name'] ?></div>
                </h6>
            <? else: ?>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item<?= (isset($menu) ? ($menu == $key ? ' active' : '') : '') ?>">
                        <a class="nav-link module_name"
                           href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= $item['link'] ?>">
                            <span class="<?= $item['icon'] ?>"></span><span class="text"><?= $item['name'] ?></span>
                        </a>
                        <? if (!empty($item['items'])): ?>
                            <ul class="submenu<?= (isset($menu) ? ($menu == $key ? ' visible' : '') : '') ?>">
                                <? foreach ($item['items'] as $sKey => $submenu): if (array_intersect($roles, $submenu['roles'])): ?>
                                    <li class="<?= (isset($sMenu) ? ($sMenu == $sKey ? ' active' : '') : '') ?>">
                                        <a class="nav-link module_name"
                                           href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= $submenu['link'] ?>">
                                            <span class="<?= $submenu['icon'] ?>"></span><span
                                                    class="text"><?= $submenu['name'] ?></span>
                                        </a>
                                    </li>
                                <? endif; endforeach; ?>
                            </ul>
                        <? endif; ?>
                    </li>
                </ul>
            <? endif ?>
        <? endif; endforeach;endif; ?>
    <? endforeach; ?>
<? endif ?>
