<?php

$app = require_once __DIR__.'/../app.php';

require_once __DIR__.'/config/load.php';

use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Higgs\Provider\UserProvider;

$app['security.firewalls'] = array(
	'main' => array(
		'users' => $app->share(function () use ($app) {
			return new UserProvider;
		}),
		'logout' => '~',
		'anonymous' => '~',
	),
);
$app->register(new TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

$app->register(new TwigServiceProvider(), array(
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

$app->match('/sign-in', function(Request $request) use ($app) {
	
	$form = $app['form.factory']->createNamedBuilder(NULL)
		->add('email', 'text', array('label'=>'email / username'))
		->add('password', 'password')
		->getForm();
	
	return $app['twig']->render('sign-in.twig', array(
		'form' => $form->createView(),
    ));
})->bind('sign-in');

$app->run();