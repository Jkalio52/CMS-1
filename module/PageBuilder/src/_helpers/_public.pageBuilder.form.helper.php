<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\PageBuilder;

use _MODULE\_DB;
use _MODULE\PageBuilder;
use _MODULE\SMTP;
use _WKNT\_INIT;
use _WKNT\_REQUEST;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;
use function json_encode;

/**
 * Class _FORM
 * @package _MODULE\PageBuilder
 */
class _FORM extends _INIT
{

    /**
     * Form Display
     */
    public static function display($formID)
    {
        if (!$formID):
            return false;
        endif;
        $decode      = explode("::", $formID);
        $id          = _SANITIZE::input($decode[1]);
        $formDetails = [];
        /**
         * Form Details
         */
        $form        = new _DB\PageBuilderForm();
        $formDetails = $form->search(
            [
                'fields' => [
                    'pbf_id'     => [
                        'type'  => '=',
                        'value' => $id
                    ],
                    'condition'  => [
                        'value' => 'and'
                    ],
                    'pbf_status' => [
                        'type'  => '=',
                        'value' => 1
                    ],
                ]
            ]);

        $itemsHtml = [];
        if (!empty($formDetails)):
            /**
             * Generate a list with the fields based on the widget id and also add the value
             */
            $fields     = new _DB\PageBuilderFormFields();
            $fieldsList = $fields->search(
                [
                    'fields' => [
                        'pbff_pbf_id' => [
                            'type'  => '=',
                            'value' => $id
                        ]
                    ],
                    'sort'   => [
                        'pbff_weight' => 'asc'
                    ]
                ]);
            foreach ($fieldsList as $item):
                $_OBJECT_METHOD = '\\_MODULE\PageBuilder\Admin\_GENERATE' . $item['pbff_type'];
                if (method_exists($_OBJECT_METHOD, 'html')):
                    $_GENERATE_HTML = new $_OBJECT_METHOD;
                    $itemsHtml[]    = $_GENERATE_HTML->html($item, false, ['unique_id' => $item['pbff_id']]);
                endif;
            endforeach;
        endif;

        PageBuilder::$_VIEW->itemsHtml   = $itemsHtml;
        PageBuilder::$_VIEW->formDetails = isset($formDetails[0]) ? $formDetails[0] : [];
        return selfRender(PageBuilder::$module, 'fields' . DIRECTORY_SEPARATOR . 'form.php');
    }

    /**
     * Ford Data Store
     */
    public function postFormStoreAction()
    {
        global $_TRANSLATION;
        $text      = $_TRANSLATION['forms']['thank_you'];
        $variables = _REQUEST::_VARIABLES(_REQUEST::_POST()['data']);

        if (isset($variables['page_builder']) && !empty($variables['page_builder'])):
            foreach ($variables['page_builder'] as $formID => $formDetails):

                /**
                 * Get the form id
                 */
                $form       = new _DB\PageBuilderForm();
                $formObject = $form->search(
                    [
                        'fields' => [
                            'pbf_machine_name' => [
                                'type'  => '=',
                                'value' => $formID
                            ]
                        ]
                    ]);
                if (!empty($formObject) && isset($formObject['0'])):
                    $text = $formObject['0']['pbf_message'];
                endif;

                /**
                 * Recaptcha Validation
                 */
                if ($formObject['0']['pbf_recaptcha']):
                    if (empty($variables['g-recaptcha-response'])):
                        $errors['form_recaptcha'][0] = [$_TRANSLATION['forms']['empty_recaptcha']];
                        return json_encode(
                            [
                                'errors'   => $errors,
                                'message'  => [
                                    'type' => 'danger',
                                    'text' => $_TRANSLATION['forms']['errors']
                                ],
                                'redirect' => false
                            ]);
                        exit(0);
                    /**
                     * Validate recaptcha
                     */
                    else:
                        if (!self::validateRecaptcha($variables['g-recaptcha-response'])):
                            $errors['form_recaptcha'][0] = [$_TRANSLATION['forms']['invalid_recaptcha']];
                            return json_encode(
                                [
                                    'errors'   => $errors,
                                    'message'  => [
                                        'type' => 'danger',
                                        'text' => $_TRANSLATION['forms']['errors']
                                    ],
                                    'redirect' => false
                                ]);
                            exit(0);
                        endif;
                    endif;
                endif;

                /**
                 * Generate the form record id
                 */
                $data               = new _DB\PageBuilderFormsData();
                $data->pbfd_pbf_id  = empty($formObject) ? null : isset($formObject['0']) ? $formObject['0']['pbf_id'] : null;
                $data->pbfd_created = _TIME::_DATE_TIME()['_NOW'];
                $dataCreate         = $data->create();

                $items = isset($formDetails[0]) ? isset($formDetails[0]['items']) ? $formDetails[0]['items'] : [] : [];
                /**
                 * Save each field value
                 */
                foreach ($items as $parent => $item):
                    $dataValue                   = new _DB\PageBuilderFormsDataValues();
                    $dataValue->pbfdv_pbf_id     = $dataCreate['id'];
                    $dataValue->pbfdv_pbff_id    = $item['id'];
                    $dataValue->pbfdv_pbff_value = $item['value'];
                    $dataValue->create();
                endforeach;

                /**
                 * Notification
                 */
                $notificationDetails               = new _DB\PageBuilderFormsDataValues();
                $notificationDetails->connSettings = [
                    'key' => 'pbfdv_pbff_id',
                ];
                $fieldsList                        = $notificationDetails->search(
                    [
                        'fields' => [
                            'pbfdv_pbf_id' => [
                                'type'  => '=',
                                'value' => $dataCreate['id']
                            ],
                        ],
                        'join'   => [
                            'page_builder_forms_fields' => [
                                'mode'    => 'left join',
                                'table'   => 'page_builder_forms_fields',
                                'conn_id' => 'pbff_id',
                                'as'      => 'pbff'
                            ]
                        ],
                    ]);

                $body = [];
                foreach ($fieldsList as $item):
                    $body[] = $item['pbff_name'] . '<br/>' . $item['pbfdv_pbff_value'] . '<br/>';
                endforeach;

                $emails = explode(",", $formObject['0']['pbf_notification_emails']);
                if (!empty($emails)):
                    foreach ($emails as $email):
                        $email = trim($email);
                        if (!empty($email)):
                            SMTP::_SEND(
                                [
                                    'to'        => $email,
                                    'subject'   => 'New form submission',
                                    'body'      => implode("<br/>", $body),
                                    'text_body' => 'New form submission',
                                ]);
                        endif;
                    endforeach;
                endif;
            endforeach;
        endif;

        return json_encode(
            [
                'errors'  => false,
                'message' => [
                    'type' => 'success',
                    'text' => $text
                ],
                'action'  => [
                    'function'  => 'clearAll',
                    'arguments' => ''
                ],
            ]);

    }

    private static function validateRecaptcha($response)
    {
        global $_APP_CONFIG;

        /**
         * Validate Recaptcha
         */

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(
            [
                'secret'   => $_APP_CONFIG['_RECAPTCHA']['SECRET_KEY'],
                'response' => $response
            ]));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        return $response['success'];
    }
}