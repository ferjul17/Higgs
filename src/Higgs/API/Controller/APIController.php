<?php

namespace Higgs\API\Controller;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

abstract class APIController implements \Silex\ControllerProviderInterface {
	
	public function connect(Application $app) {
		$controller = $app['controllers_factory'];
		$actions = get_class_methods($this);
		foreach ($actions as $action) {
			if (substr($action, -6) !== 'Action') continue;
			$controller->match('/'.substr($action, 0, -6), function (Request $request, Application $app) use ($action) {
				$method = new \ReflectionMethod(get_called_class(), $action);
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
				return $method->invokeArgs(null, $paramsGiven);
			});
		}
		return $controller;
	}
	
}

?>
