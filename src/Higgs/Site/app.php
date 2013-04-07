<?php

define('ROOT_DIR', realpath(__DIR__.'/../../..'));

require_once ROOT_DIR.'/vendor/autoload.php';

$app = new \Silex\Application();

require_once __DIR__.'/config/load.php';

use Symfony\Component\HttpFoundation\Request;

$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

$app->register(new \Propel\Silex\PropelServiceProvider(), array(
    'propel.path'        => ROOT_DIR.'/vendor/propel/propel1/runtime/lib/Propel.php',
    'propel.config_file' => ROOT_DIR.'/setup/Propel/build/conf/Higgs-conf.php',
    'propel.model_path'  => ROOT_DIR.'/src/Higgs/Model/',
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->match('/', function() use ($app) {
	return $app['twig']->render('index.twig', array(
    ));
})->bind('home');

$app->match('/sign-up', function(Request $request) use ($app) {
	
	$form = $app['form.factory']->createNamedBuilder(NULL)
		->add('username', 'text')
		->add('email', 'email')
		->add('password', 'password')
		->getForm();
	
	return $app['twig']->render('sign-up.twig', array(
		'form' => $form->createView(),
    ));
})->bind('sign-up');

$app->run();