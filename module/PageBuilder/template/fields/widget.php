<div id="<?= isset($itemDetails['pbo_id']) ? $itemDetails['pbo_id'] : '' ?>" <?= $itemDetails['pbo_repeater'] ? 'repeater="true"' : '' ?>
     machine_name="<?= isset($itemDetails['pbo_machine_name']) ? $itemDetails['pbo_machine_name'] : '' ?>"
     class="widget-items <?= isset($itemDetails['pbo_machine_name']) ? $itemDetails['pbo_machine_name'] : '' ?>">
    <div class="widget-name"><?= isset($itemDetails['pbo_name']) ? $itemDetails['pbo_name'] : '' ?></div>
    <div class="widget-control" action="slide"><span class="oi oi-plus"></span></div>
    <div class="widget-delete"><span class="oi oi-trash"></span></div>
    <div class="widget-content-hide widget-items-list<? if ($itemDetails['pbo_repeater']): ?> sortable-repeater<? endif ?>">
        <? if ($itemDetails['pbo_repeater']): ?>
            <? if (isset($emptyWidget)): ?>

                <? foreach ($itemsHtml as $item): ?>
                    <div class="wi">
                        <? if ($itemDetails['pbo_repeater']): ?>
                            <div class="wi-remove"></div><? endif ?>
                        <?= implode("", $item) ?>
                    </div>
                <? endforeach; ?>
            <? else: ?>
                <div class="wi">
                    <? if ($itemDetails['pbo_repeater']): ?>
                        <div class="wi-remove"></div><? endif ?>
                    <?= implode("", $itemsHtml) ?>
                </div>
            <? endif ?>
        <? else: ?>
            <?= implode("", $itemsHtml) ?>
        <? endif; ?>

        <? if ($itemDetails['pbo_repeater']): ?>
            <div class="repeater-container text-md-right">
                <div class="repeat-fields d-none">
                    <div class="wi-remove"></div>
                    <? if (isset($emptyWidget)): ?>
                        <?= $emptyWidget ?>
                    <? else: ?>
                        <? $string = implode("", $itemsHtml); ?>
                        <?= str_replace("editor", "editor-object", $string) ?>
                    <? endif ?>
                </div>
                <div class="btn custom-btn btn-outline-info repeater">
                    Repeat
                </div>
            </div>
        <? endif; ?>
    </div>
</div>