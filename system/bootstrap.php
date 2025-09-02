<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
/**
 * ---------------------------------------------------------------
 * This file cannot be used. The code has moved to Boot.php.
 * ---------------------------------------------------------------
 */

use CodeIgniter\Exceptions\FrameworkException;
use Config\Autoload;
use Config\Modules;
use Config\Paths;
use Config\Services;

header('HTTP/1.1 503 Service Unavailable.', true, 503);

$message = 'This "system/bootstrap.php" is no longer used. If you are seeing this error message,
the upgrade is not complete. Please refer to the upgrade guide and complete the upgrade.
See https://codeigniter4.github.io/userguide/installation/upgrade_450.html' . PHP_EOL;
echo $message;

/*
 * ---------------------------------------------------------------
 * SETUP OUR PATH CONSTANTS
 * ---------------------------------------------------------------
 *
 * The path constants provide convenient access to the folders
 * throughout the application. We have to setup them up here
 * so they are available in the config files that are loaded.
 */

/** @var Paths $paths */

// The path to the application directory.
if (! defined('APPPATH')) {
    define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the project root directory. Just above APPPATH.
if (! defined('ROOTPATH')) {
    define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
}

// The path to the system directory.
if (! defined('SYSTEMPATH')) {
    define('SYSTEMPATH', realpath(rtrim($paths->systemDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the writable directory.
if (! defined('WRITEPATH')) {
    define('WRITEPATH', realpath(rtrim($paths->writableDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the tests directory
if (! defined('TESTPATH')) {
    define('TESTPATH', realpath(rtrim($paths->testsDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

/*
 * ---------------------------------------------------------------
 * GRAB OUR CONSTANTS
 * ---------------------------------------------------------------
 */

if (! defined('APP_NAMESPACE')) {
    require_once APPPATH . 'Config/Constants.php';
}

/*
 * ---------------------------------------------------------------
 * LOAD COMMON FUNCTIONS
 * ---------------------------------------------------------------
 */

// Require app/Common.php file if exists.
if (is_file(APPPATH . 'Common.php')) {
    require_once APPPATH . 'Common.php';
}

// Require system/Common.php
require_once SYSTEMPATH . 'Common.php';

/*
 * ---------------------------------------------------------------
 * LOAD OUR AUTOLOADER
 * ---------------------------------------------------------------
 *
 * The autoloader allows all of the pieces to work together in the
 * framework. We have to load it here, though, so that the config
 * files can use the path constants.
 */

if (! class_exists(Autoload::class, false)) {
    require_once SYSTEMPATH . 'Config/AutoloadConfig.php';
    require_once APPPATH . 'Config/Autoload.php';
    require_once SYSTEMPATH . 'Modules/Modules.php';
    require_once APPPATH . 'Config/Modules.php';
}

require_once SYSTEMPATH . 'Autoloader/Autoloader.php';
require_once SYSTEMPATH . 'Config/BaseService.php';
require_once SYSTEMPATH . 'Config/Services.php';
require_once APPPATH . 'Config/Services.php';

// Initialize and register the loader with the SPL autoloader stack.
Services::autoloader()->initialize(new Autoload(), new Modules())->register();
Services::autoloader()->loadHelpers();

/*
 * ---------------------------------------------------------------
 * SET EXCEPTION AND ERROR HANDLERS
 * ---------------------------------------------------------------
 */

Services::exceptions()->initialize();

/*
 * ---------------------------------------------------------------
 * CHECK SYSTEM FOR MISSING REQUIRED PHP EXTENSIONS
 * ---------------------------------------------------------------
 */

// Run this check for manual installations
if (! is_file(COMPOSER_PATH)) {
    $missingExtensions = [];

    foreach ([
        'intl',
        'json',
        'mbstring',
    ] as $extension) {
        if (! extension_loaded($extension)) {
            $missingExtensions[] = $extension;
        }
    }

    if ($missingExtensions !== []) {
        throw FrameworkException::forMissingExtension(implode(', ', $missingExtensions));
    }

    unset($missingExtensions);
}

/*
 * ---------------------------------------------------------------
 * INITIALIZE KINT
 * ---------------------------------------------------------------
 */

Services::autoloader()->initializeKint(CI_DEBUG);

exit(1);
<<<<<<< HEAD
=======
use CodeIgniter\Boot;
use Config\Paths;

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

/*
 * ---------------------------------------------------------------
 * DEFINE ENVIRONMENT
 * ---------------------------------------------------------------
 */

// Make sure it recognizes that we're testing.
$_SERVER['CI_ENVIRONMENT'] = 'testing';
define('ENVIRONMENT', 'testing');

defined('CI_DEBUG') || define('CI_DEBUG', true);

/*
 * ---------------------------------------------------------------
 * SET UP OUR PATH CONSTANTS
 * ---------------------------------------------------------------
 *
 * The path constants provide convenient access to the folders
 * throughout the application. We have to set them up here
 * so they are available in the config files that are loaded.
 */

// Often these constants are pre-defined, but query the current directory structure as a fallback
defined('HOMEPATH') || define('HOMEPATH', realpath(rtrim(getcwd(), '\\/ ')) . DIRECTORY_SEPARATOR);
$source = is_dir(HOMEPATH . 'app')
    ? HOMEPATH
    : (is_dir('vendor/codeigniter4/framework/') ? 'vendor/codeigniter4/framework/' : 'vendor/codeigniter4/codeigniter4/');
defined('CONFIGPATH') || define('CONFIGPATH', realpath($source . 'app/Config') . DIRECTORY_SEPARATOR);
defined('PUBLICPATH') || define('PUBLICPATH', realpath($source . 'public') . DIRECTORY_SEPARATOR);
unset($source);

// LOAD OUR PATHS CONFIG FILE
// Load framework paths from their config file
require CONFIGPATH . 'Paths.php';
$paths = new Paths();

// Define necessary framework path constants
defined('APPPATH')    || define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
defined('ROOTPATH')   || define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
defined('SYSTEMPATH') || define('SYSTEMPATH', realpath(rtrim($paths->systemDirectory, '\\/')) . DIRECTORY_SEPARATOR);
defined('WRITEPATH')  || define('WRITEPATH', realpath(rtrim($paths->writableDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
defined('TESTPATH')   || define('TESTPATH', realpath(HOMEPATH . 'tests/') . DIRECTORY_SEPARATOR);

defined('CIPATH') || define('CIPATH', realpath(SYSTEMPATH . '../') . DIRECTORY_SEPARATOR);
defined('FCPATH') || define('FCPATH', realpath(PUBLICPATH) . DIRECTORY_SEPARATOR);

defined('SUPPORTPATH')   || define('SUPPORTPATH', realpath(TESTPATH . '_support/') . DIRECTORY_SEPARATOR);
defined('COMPOSER_PATH') || define('COMPOSER_PATH', (string) realpath(HOMEPATH . 'vendor/autoload.php'));
defined('VENDORPATH')    || define('VENDORPATH', realpath(HOMEPATH . 'vendor') . DIRECTORY_SEPARATOR);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';
Boot::bootTest($paths);

/*
 * ---------------------------------------------------------------
 * LOAD ROUTES
 * ---------------------------------------------------------------
 */

service('routes')->loadRoutes();
>>>>>>> 37bee22 (Add database migrations and seeders)
=======
>>>>>>> 93a09e5307e0f02cc1dbf798a06b1a8fc5edd195
