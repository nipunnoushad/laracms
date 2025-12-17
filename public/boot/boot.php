<?php

/*----------------------------------------------------------------
 * NEXTLOOP
 * @description
 * Check system meets some minimum requirements before continuing
 *   - PHP Version ( >= 7.2.5)
 *   - Writable directory permissions
 *
 * @updated
 * 26 October 2020
 *---------------------------------------------------------------*/
if (!defined('SANITYCHECKS')) {
    die('Access is not permitted');
}

$errors = 0;
$messages_chmod = '';
$messages_php = '';

$paths = [
//    '/updates',
//    '/storage',
//    '/storage/avatars',
//    '/storage/logos',
//    '/storage/logos/clients',
//    '/storage/logos/app',
//    '/storage/files',
//    '/storage/temp',
    '/application/storage/app',
    '/application/storage/app/public',
//    '/application/storage/cache',
//    '/application/storage/cache/data',
//    '/application/storage/debugbar',
    '/application/storage/framework',
    '/application/storage/framework/cache',
    '/application/storage/framework/cache/data',
    '/application/storage/framework/sessions',
    '/application/storage/framework/testing',
    '/application/storage/framework/views',
    '/application/storage/logs',
    '/application/bootstrap/cache',
//    '/application/storage/app/purifier',
//    '/application/storage/app/purifier/HTML',
];

//Subdomain - Subfolder Fix
if (!is_dir(BASE_PATH . '/application')) {
    die('Error! - You cannot access the CRM from this url');
}

//check directoies
foreach ($paths as $key => $value) {
    if (!is_writable(BASE_PATH . $value)) {
        $messages_chmod .= '<tr><td class="p-l-15">' . BASE_PATH . $value . '</td><td class="x-td-checks" width="40px"><span class="x-checks x-check-failed text-danger font-18"><i class="sl-icon-close"></i></span></td></tr>';
        $errors++;
    } else {
        $messages_chmod .= '<tr><td class="p-l-15">' . BASE_PATH . $value . '</td><td class="x-td-checks" width="40px"><span class="x-checks x-check-passed text-info font-18"><i class="sl-icon-check"></i></span></td></tr>';
    }
}

//check minimum php version
if (version_compare(PHP_VERSION, '7.4', ">=")) {
    $messages_php = '<tr><td class="p-l-15">PHP >= v7.4 </td><td class="x-td-checks" width="40px"><span class="x-checks x-check-passed text-info font-18"><i class="sl-icon-check"></i></span></td></tr>';
} else {
    $messages_php = '<tr><td class="p-l-15">PHP >= v7.4 </td><td class="x-td-checks" width="40px"><span class="x-checks x-check-failed text-danger font-18"><i class="sl-icon-close"></i></span></td></tr>';
    $errors++;

}

//page


//do we have directory errors
if ($errors > 0) {
    die($page = require BASE_PATH.'/public/boot/index.php');
}
