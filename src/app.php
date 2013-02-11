<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.path'        => __DIR__.'/../vendor/propel/propel1/runtime/lib/Propel.php',
    'propel.config_file' => __DIR__.'/../resources/propel/build/conf/Higgs-conf.php',
    'propel.model_path'  => __DIR__.'/../resources/propel/build/classes',
));

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// include API
call_user_func(function () use($app) {
	chdir(__DIR__.'/api');
	foreach (glob('*.php') as $file) {
		$api = substr($file,0,-4);
		$app->mount('/api/'.$api, include $file);
	}
});

$app->run();
?>
