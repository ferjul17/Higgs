<?php

namespace Higgs\API;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

abstract class BaseController implements \Silex\ControllerProviderInterface {
	
	public function connect(Application $app) {
		$controller = $app['controllers_factory'];
		$actions = get_class_methods($this);
		foreach ($actions as $action) {
			if (substr($action, -6) !== 'Action') continue;
			$controller->match('/'.substr($action, 0, -6), function (Request $request, Application $app) use ($action) {
				$method = new \ReflectionMethod($this, $action);
				$params = $method->getParameters();
				$paramsGiven = [];
				foreach ($params as $param) {
					$paramName = $param->getName();
					switch ($paramName) {
						case 'request':
							$paramValue = $request;
							break;
						case 'app':
							$paramValue = $app;
							break;
						default:
							$paramValue = &$request->get($paramName);
							if (!isset($paramValue)) {
								if (!$param->isDefaultValueAvailable()) {
									$app->abort(400, $paramName.' is mandatory');		
								}
								$paramValue = $param->getDefaultValue();
							}
					}
					$paramsGiven[$param->getPosition()] = $paramValue;
				}
				$response = $method->invokeArgs($this, $paramsGiven);
				var_dump($response,is_object($response),is_callable($response->toJSON));
				if (is_object($response) && is_callable($response->toJSON)) {
					$response = $response->toJSON();
				}
				return $app->json($response);
			});
		}
		return $controller;
	}
	
}

?>
