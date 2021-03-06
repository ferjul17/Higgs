<?php

$app = require_once __DIR__.'/../app.php';

require_once __DIR__.'/config/load.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\ValidatorServiceProvider;
use Higgs\Provider\UserProvider;

$app->register(new ValidatorServiceProvider());

$app['security.firewalls'] = array(
	'main' => array(
		'users' => $app->share(function () use ($app) {
			return new UserProvider;
		}),
		'pattern' => '/User',
		'form' => array(
			'check_path' => '/User/login',
			'login_path' => '/../Higgs/sign-in',
			'default_target_path' => '/../Higgs/',
			'username_parameter' => 'email',
			'password_parameter' => 'password',
			'post_only' => false,
		),
		'logout' => '~',
		'anonymous' => '~',
	),
);

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// include API
call_user_func(function () use($app) {
	chdir(__DIR__.'/Route');
	foreach (glob('*.php') as $file) {
		$api = substr($file,0,-4);
		$controller = '\\Higgs\\API\\Route\\'.$api;
		$app->mount('/'.$api, new $controller);
	}
});

$app->error(function(\Exception $e, $code) use($app) {
	if ($app['debug']) return;
	switch ($code) {
		case 400:	$message = 'Bad request';	break;
		case 403:	$message = 'Forbidden'; break;
		case 404:	$message = 'API not found'; break;
		default:	$message = 'Internal Error';
	}
	return new Response($message, $code);	
});

$app->after(function(Request $request, Response $response) use ($app) {
	if ($app['debug'] && $response->getStatusCode() != 200)
		return;
	$response->headers->set('Content-type', 'text/json');
});

$app->run();

?>
