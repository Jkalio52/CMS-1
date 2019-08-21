<?php
/**
 * @package   WarpKnot
 */

namespace _MODULE\DatabaseUpdates;

use _MODULE\_DB;
use _WKNT\_CONFIG;
use _WKNT\_CRUD;
use _WKNT\_INIT;
use _WKNT\_MESSAGE;
use _WKNT\_PAGINATION;
use _WKNT\_REQUEST;
use _WKNT\_ROUTE;
use _WKNT\_SANITIZE;
use _WKNT\_TIME;

/**
 * Class Admin
 * @package _MODULE\DatabaseUpdates
 */
class Admin extends _INIT
{
    private static $module = 'DatabaseUpdates\Admin',
        $moduleTemplate = 'Dashboard',
        $templatesDirectory = 'DatabaseUpdates';

    /**
     * Generate the dashboard template
     *
     * @param $page
     */
    private static function template($page)
    {
        self::$_VRS = [
            'header'  => selfRender(self::$moduleTemplate, 'partials/header.php'),
            'footer'  => selfRender(self::$moduleTemplate, 'partials/footer.php'),
            'content' => selfRender(self::$templatesDirectory, $page)
        ];
    }


    /**
     * Pending Updates
     */
    public static function getPendingAction()
    {
        global $_TRANSLATION, $__DIRECTORIES, $_APP_CONFIG;
        /**
         * Scan for SQL Files
         */
        $_PENDING = [];
        foreach (glob($__DIRECTORIES['_MODULE'] . "*") as $module):
            foreach (glob($module . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . "*.sql.php") as $filename):
                /**
                 * Filename Validation
                 */
                $migrate_filename = _SANITIZE::input(basename($filename));
                $migrate_module   = _SANITIZE::input(basename($module));
                $object           = new _DB\Migrate();
                $objectFind       = $object->search(
                    [
                        'fields' => [
                            'migrate_filename' => [
                                'type'  => '=',
                                'value' => $migrate_filename
                            ],
                            'condition'        => [
                                'value' => 'and'
                            ],
                            'migrate_module'   => [
                                'type'  => '=',
                                'value' => $migrate_module
                            ]
                        ]
                    ]);
                if (empty($objectFind)):
                    $_PENDING[] = [
                        'module'      => $migrate_module,
                        'filename'    => substr_replace($migrate_filename, "", -4),
                        'description' => str_replace(['<? /**', '*/ ?>'], ['', ''], fgets(fopen($filename, 'r')))
                    ];
                endif;
            endforeach;
        endforeach;

        self::$_VIEW->_PENDING         = $_PENDING;
        self::$_VIEW->menu             = 'migrate';
        self::$_VIEW->sMenu            = 'pending';
        self::$_VIEW->page_title       = $_TRANSLATION['database_updates']['pending']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['database_updates']['pending']['seo_description'];

        self::template('admin/pending.php');
    }


    /**
     * Migrations Log
     */
    public static function getLogAction()
    {
        global $_TRANSLATION, $_APP_CONFIG;

        $objects     = new _DB\Migrate();
        $objectsList = $objects->search(
            [
                'sort' => [
                    'mid' => 'desc'
                ]
            ]);

        self::$_VIEW->objects = _PAGINATION::_GENERATE(
            [
                '_HASHTAG'        => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/pages',
                '_PAGE_LINK'      => $_APP_CONFIG['_DOMAIN_ROOT'] . 'admin/pages',
                '_CURRENT_PAGE'   => _PAGINATION::_CURRENT_PAGE(),
                '_TOTAL_ITEMS'    => count($objectsList),
                '_ITEMS_PER_PAGE' => $_APP_CONFIG['pagination_limit'],
                '_ITEMS'          => $objectsList
            ]
        );


        self::$_VIEW->menu             = 'migrate';
        self::$_VIEW->sMenu            = 'migrated';
        self::$_VIEW->page_title       = $_TRANSLATION['database_updates']['log']['seo_title'];
        self::$_VIEW->page_description = $_TRANSLATION['database_updates']['log']['seo_description'];

        self::template('admin/log.php');
    }

    /**
     * Apply New Migration
     */
    public static function getMigrateAction()
    {
        global $_TRANSLATION, $__DIRECTORIES;
        $_REQUEST_ID = _REQUEST::_REQUEST_ID();
        if (count($_REQUEST_ID) < 2):
            _MESSAGE::set($_TRANSLATION['database_updates']['invalid_request'], 'danger');
            _ROUTE::_REDIRECT('admin/migrate');
        else:
            $fileLocation = $__DIRECTORIES['_MODULE'] . $_REQUEST_ID[0] . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . $_REQUEST_ID[1] . '.php';
            if (file_exists($fileLocation)):
                $query = _CONFIG::_LOAD(['_FILE_LOCATION' => $fileLocation]);
                /**
                 * Query Execute
                 */
                if (!empty($query)):
                    foreach ($query as $item):
                        $queryExec = new _CRUD();
                        $queryExec->exec($item);
                    endforeach;
                endif;
                /**
                 * Mark the file as imported
                 */
                $import                   = new _DB\Migrate();
                $import->migrate_filename = $_REQUEST_ID[1] . '.php';
                $import->migrate_module   = $_REQUEST_ID[0];
                $import->migrate_date     = _TIME::_DATE_TIME()['_NOW'];
                $import->create();
                _MESSAGE::set($_TRANSLATION['database_updates']['migrated'], 'success');
            else:
                _MESSAGE::set($_TRANSLATION['database_updates']['missing_file'], 'danger');
            endif;
        endif;

        _ROUTE::_REDIRECT('admin/migrate');
    }

}