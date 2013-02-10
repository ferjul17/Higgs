<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Propel\Silex\PropelServiceProvider(), array(
    'propel.path'        => __DIR__.'/../vendor/propel/propel1/runtime/lib/Propel.php',
    'propel.config_file' => __DIR__.'/../resources/propel/build/conf/Higgs-conf.php',
    'propel.model_path'  => __DIR__.'/../resources/propel/build/classes',
));

$app->get('/hello', function() {
    return 'Hello!';
});

$app->run();
