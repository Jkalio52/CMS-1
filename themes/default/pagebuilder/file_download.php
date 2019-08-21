<? if (!empty($file_download)): ?>
    <div class="widget content file_download">
        <div class="container">
            <? foreach ($file_download as $file):
                if (isset($file['columns'])):switch ($file['columns']):
                    case 1:
                        $columns = 'col-md-3 col-lg-1 col-xl-1';
                        break;
                    case 2:
                        $columns = 'col-md-4 col-lg-2';
                        break;
                    case 3:
                        $columns = 'col-md-4 col-lg-3';
                        break;
                    case 4:
                        $columns = 'col-md-6 col-lg-4';
                        break;
                    case 5:
                        $columns = 'col-md-5 col-lg-5';
                        break;
                    case 6:
                        $columns = 'col-md-6 col-lg-6';
                        break;
                    case 7:
                        $columns = 'col-md-7 col-lg-7';
                        break;
                    case 8:
                        $columns = 'col-md-8 col-lg-8';
                        break;
                    case 9:
                        $columns = 'col-md-9 col-lg-9';
                        break;
                    case 10:
                        $columns = 'col-md-10 col-lg-10';
                        break;
                    case 11:
                        $columns = 'col-md-11 col-lg-11';
                        break;
                    case 12:
                        $columns = 'col-md-12 col-lg-12';
                        break;
                endswitch;endif; ?>
                <div class="row justify-content-<?= isset($file['column_align']) ? $file['column_align'] : '' ?> mb-3">
                    <div class="col-sm-12 <?= $columns ?>">
                        <div class="download-button d-md-flex align-items-center">
                            <div class="download-button-icon mb-3 mb-md-0">
                                <img src="<?= fileIcon($file['file'], $file['icon_style']) ?>"/>
                            </div>
                            <div class="download-button-details">
                                <div class="download-button-details-text"><?= $file['name'] ?></div>
                                <div class="download-button-details-file_size">
                                    File size <?= fileToSize($file['file']) ?></div>
                            </div>
                            <div class="download-button-action">
                                <a href="<?= fileSrc($file['file']) ?>" class="btn btn-secondary transparent reverse"
                                   title="<?= $file['name'] ?>" target="_blank">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach ?>
        </div>
    </div>
<? endif ?>