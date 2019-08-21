<div class="social_icons">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <? if (!empty($social_links)): ?>
                    <? foreach ($social_links as $link): ?>
                        <a class="<?= isset($link['icon']) ? $link['icon'] : '' ?> social-button <?= isset($link['style']) ? $link['style'] : '' ?> <?= isset($link['animation']) ? $link['animation'] : '' ?>"
                           href="<?= isset($link['link']) ? $link['link'] : '' ?>"></a>
                    <? endforeach ?>
                <? endif ?>
            </div>
        </div>
    </div>
</div>