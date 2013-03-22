<?php

define('ROOT_DIR', realpath(__DIR__.'/../../..'));

require_once ROOT_DIR.'/vendor/autoload.php';

$app = new \Silex\Application();

require_once __DIR__.'/config/load.php';

use Symfony\Component\HttpFoundation\Request;

$app->register(new \Propel\Silex\PropelServiceProvider(), array(
    'propel.path'        => ROOT_DIR.'/vendor/propel/propel1/runtime/lib/Propel.php',
    'propel.config_file' => ROOT_DIR.'/resources/propel/build/conf/Higgs-conf.php',
    'propel.model_path'  => ROOT_DIR.'/resources/propel/build/classes',
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->match('/', function() use ($app) {
	return $app['twig']->render('index.twig', array(
    ));
});

$app->run();