<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-7">
            <div class="doughnutPieChart" id="chart_<?= $pbd_id ?>"
                 chart-type="<?= isset($chart_type) ? $chart_type : '' ?>"
                 label="<?= isset($chart_label) ? $chart_label : '' ?>"
                 labels="<?= isset($labels) ? $labels : '' ?>"
                 data="<?= isset($data) ? $data : '' ?>"
                 background="<?= isset($background_colors) ? $background_colors : '' ?>">
                <canvas class="doughnutPieChart__canvas"></canvas>
            </div>
        </div>
    </div>
</div>