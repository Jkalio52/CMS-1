<div class="custom-tabs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <? if (isset($tabs)): ?>
                    <ul class="nav" role="tablist">
                        <? $i = 0;
                        if (!empty($tabs)):
                            foreach ($tabs as $key => $tab):$i++ ?>
                                <li class="nav-item">
                                    <a class="<?= ($i == 1 ? ' active' : '') ?>"
                                       id="action_<?= $i ?>_<?= $pbd_id ?>-tab"
                                       data-toggle="pill"
                                       href="#tab__<?= $i ?>_<?= $pbd_id ?>" role="tab"
                                       aria-controls="tab__<?= $i ?>_<?= $pbd_id ?>"
                                       aria-selected="<?= ($i == 1 ? 'true' : 'false') ?>">
                                        <?= $tab['name'] ?>
                                    </a>
                                </li>
                            <? endforeach; endif; ?>
                    </ul>
                    <div class="tab-content">
                        <? $i = 0;
                        if (!empty($tabs)):
                            foreach ($tabs as $key => $tab):$i++ ?>
                                <div class="tab-pane fade<?= ($i == 1 ? ' show active' : '') ?>"
                                     id="tab__<?= $i ?>_<?= $pbd_id ?>"
                                     role="tabpanel"
                                     aria-labelledby="action_<?= $i ?>_<?= $pbd_id ?>-tab">
                                    <?= $tab['text'] ?>
                                </div>
                            <? endforeach; endif; ?>
                    </div>
                <? endif ?>
            </div>
        </div>
    </div>
</div>