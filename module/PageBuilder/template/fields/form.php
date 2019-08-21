<? if (!empty($formDetails)): ?>
    <? if ($formDetails['pbf_recaptcha']): ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <? endif ?>
    <div class="page-builder-group page-builder page_builder__form <?= $formDetails['pbf_machine_name'] ?>">
        <div id="<?= $formDetails['pbf_machine_name'] ?>" class="current-fields">
            <form data_id="_FORM_POST"
                  action="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>form/post"
                  method="post"
                  class="form-post widget-items">
                <?= implode("", $itemsHtml) ?>
                <? if ($formDetails['pbf_recaptcha']): ?>
                    <div class="mb-3">
                        <div class="g-recaptcha"
                             data-sitekey="<?= isset($_APP_CONFIG['_RECAPTCHA']['SITE_KEY']) ? $_APP_CONFIG['_RECAPTCHA']['SITE_KEY'] : '' ?>"></div>
                        <div class="btn btn-link reverse my-auto" onclick="grecaptcha.reset()">
                            Recaptcha reload
                        </div>
                    </div>
                    <div class="errors error form_recaptcha_errors"></div>
                <? endif ?>
                <div class="message"></div>
                <button class="btn btn-success transparent reverse">
                    <?= $formDetails['pbf_button_name'] ?>
                </button>
            </form>
        </div>
    </div>
<? endif; ?>
