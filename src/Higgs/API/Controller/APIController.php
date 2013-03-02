<?php

namespace Higgs\API\Controller;

abstract class APIController implements \Silex\ControllerProviderInterface {
	
	public function connect(\Silex\Application $app) {
		$controller = $app['controllers_factory'];
		$actions = get_class_methods($this);
		foreach ($actions as $action) {
			if (substr($action, -6) !== 'Action') continue;
			$controller->match('/'.substr($action, 0, -6), get_called_class().'::'.$action);
		}
		return $controller;
	}
	
}

?>
