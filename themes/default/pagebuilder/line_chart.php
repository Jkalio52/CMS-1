<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-7">
            <div class="lineChart" id="chart_<?= $pbd_id ?>" label="<?= isset($chart_label) ? $chart_label : '' ?>"
                 labels="<?= isset($labels) ? $labels : '' ?>"
                 data="<?= isset($data) ? $data : '' ?>" borderColor="<?= isset($border_color) ? $border_color : '' ?>">
                <canvas class="lineChart__canvas"></canvas>
            </div>
        </div>
    </div>
</div>
