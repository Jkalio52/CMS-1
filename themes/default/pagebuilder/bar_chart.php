<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-7">
            <div class="barChart" id="chart_<?= $pbd_id ?>" label="<?= isset($chart_label) ? $chart_label : '' ?>"
                 labels="<?= isset($labels) ? $labels : '' ?>"
                 chartStyle="<?= ($horizontal_bar ? 'horizontalBar' : 'bar') ?>"
                 data="<?= isset($data) ? $data : '' ?>"
                 background="<?= isset($background_colors) ? $background_colors : '' ?>">
                <canvas class="barChart__canvas"></canvas>
            </div>
        </div>
    </div>
</div>