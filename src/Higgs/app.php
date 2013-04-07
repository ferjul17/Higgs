<?php

define('ROOT_DIR', realpath(__DIR__.'/../..'));

require_once ROOT_DIR.'/vendor/autoload.php';

use Silex\Application;
use Propel\Silex\PropelServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use \Silex\Provider\SessionServiceProvider;
use \Silex\Provider\SecurityServiceProvider;

$app = new \Silex\Application();

$app->register(new PropelServiceProvider(), array(
    'propel.path'        => ROOT_DIR.'/vendor/propel/propel1/runtime/lib/Propel.php',
    'propel.config_file' => ROOT_DIR.'/setup/Propel/build/conf/Higgs-conf.php',
    'propel.model_path'  => ROOT_DIR.'/src/Higgs/Model/',
));

$app->register(new FormServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new SecurityServiceProvider());

return $app;