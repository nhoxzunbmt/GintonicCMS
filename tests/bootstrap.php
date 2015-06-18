<?php
// @codingStandardsIgnoreFile
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Network\Email\Email;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;
require_once 'vendor/autoload.php';
// Path constants to a few helpful things.
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__) . DS);
define('CAKE_CORE_INCLUDE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp');
define('CORE_PATH', ROOT . 'vendor' . DS . 'cakephp' . DS . 'cakephp' . DS);
define('CAKE', CORE_PATH . 'src' . DS);
define('TESTS', ROOT . 'tests');
define('APP', ROOT . 'tests' . DS);
define('APP_DIR', 'app');
define('WEBROOT_DIR', 'webroot');
define('WWW_ROOT', dirname(APP) . DS . 'webroot' . DS);
define('TMP', sys_get_temp_dir() . DS);
define('CONFIG', ROOT . 'tests' . DS . 'config' . DS);
define('CACHE', TMP);
define('LOGS', TMP);
require_once CORE_PATH . 'config/bootstrap.php';
date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');
Configure::write('debug', true);
Cake\Core\Configure::write('App', ['namespace' => 'GintonicCMS\Test\App']);
Cache::config([
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}
Cake\Datasource\ConnectionManager::config('test', [
    'url' => getenv('db_dsn'),
    'timezone' => 'UTC'
]);

Plugin::load('GintonicCMS', ['path' => ROOT]);

Configure::write('Acl.classname', 'DbAcl');
Configure::write('Acl.database', 'default');
Configure::load('email');
Configure::load('app');
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));

Configure::write('Gintonic.website.name', 'GintonicCMS');
Cake\Routing\DispatcherFactory::add('Routing');
Cake\Routing\DispatcherFactory::add('ControllerFactory');
