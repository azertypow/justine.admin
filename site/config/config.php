<?php

/**
 * The config file is optional. It accepts a return array with config options
 * Note: Never include more than one return statement, all options go within this single return array
 * In this example, we set debugging to true, so that errors are displayed onscreen.
 * This setting must be set to false in production.
 * All config options: https://getkirby.com/docs/reference/system/options
 */
return [
    'debug' => true,
    'routes' => [
        [
            'pattern' => '/',
            'action' => function () {
                go('panel');
            },
        ],
        [
            'pattern' => '/site-info',
            'action' => function() {
                include_once 'site/templates/getSiteInfo.php';

                header("Access-Control-Allow-Origin: *");

                return \Kirby\Cms\Response::json(
                    getSiteInfo(kirby(), site())
                );
            }
        ],
        [
            'pattern' => '/project-by-slug/(:any)',
            'action' => function($pageSlug) {
                include_once 'site/templates/getProjectByUid.php';

                header("Access-Control-Allow-Origin: *");

                return \Kirby\Cms\Response::json(
                    getProjectBySlug($pageSlug, kirby(), site())
                );
            }
        ],
        [
            'pattern' => '/project-by-slug/(:any)',
            'action' => function($pageSlug) {
                include_once 'site/templates/getProjectByUid.php';

                header("Access-Control-Allow-Origin: *");

                return \Kirby\Cms\Response::json(
                    getProjectBySlug($pageSlug, kirby(), site())
                );
            }
        ],
        [
            'pattern' => '/about',
            'action'  => function () {
                header("Access-Control-Allow-Origin: *");
                include_once 'site/templates/get.about.php';
                return getAbout(kirby(), site());
            }
        ],
        [
            'pattern' => '/contact',
            'action'  => function () {
                header("Access-Control-Allow-Origin: *");
                include_once 'site/templates/get.contact.php';
                return getContact(kirby(), site());
            }
        ]
    ],
    'panel' => [
        'css' => 'site/plugins/custom-panel/css/main.css'
    ]
];
