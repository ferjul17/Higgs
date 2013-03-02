<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require_once __DIR__.'/config/load.php';

use Symfony\Component\HttpFoundation\Request;

$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.path'        => __DIR__.'/../vendor/propel/propel1/runtime/lib/Propel.php',
    'propel.config_file' => __DIR__.'/../resources/propel/build/conf/Higgs-conf.php',
    'propel.model_path'  => __DIR__.'/../resources/propel/build/classes',
));

// include API
call_user_func(function () use($app) {
	chdir(__DIR__.'/site');
	foreach (glob('*.php') as $file) {
		$api = substr($file,0,-4);
		$app->mount('/'.$api, include $file);
	}
});

$app->run();

?>
