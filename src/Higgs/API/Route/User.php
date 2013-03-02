<?php

namespace Higgs\API\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class User extends \Higgs\API\Controller\APIController {
	
	public static function createAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);

		$user = new \Higgs\Model\User;
		
		$factory = $app['security.encoder_factory'];
		$encoder = $factory->getEncoder($user);
		$password = $encoder->encodePassword($request->get('password'), $user->getSalt());
		
		$user->setPassword($password);
		$user->setUsername($request->get('username'));
		$user->setEmail($request->get('email'));
		if (!$user) $app->abort(400);
		$user->save();

		return $app->json($user->toJSON());
		
	}
	
	public static function getAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$user = \Higgs\Model\UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort (400);
		return $user;
		
		
		
	}
	
	public static function listAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$users = \Higgs\Model\UserQuery::create()->find();
		if (!$users->validate()) $app->abort (400);
		return $users;
		
	}
	
	public static function deleteAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$user = \Higgs\Model\UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort (400);
		$user->delete();
		return $user;
		
	}
	
	public static function updateAction (Request $request, Application $app) {
		
		$user = \Higgs\Model\UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort(400);
		$user->setPassword(sha1($request->get('password')));
		$user->setUsername($request->get('username'));
		$user->setEmail($request->get('email'));
		if (!$user->validate()) $app->abort(400);
		$user->save();
		return $user;
		
	}
	
	public static function loginAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);
		
		$user = \Higgs\Model\UserQuery::create()
				->filterByEmail($request->get('email'))
				->findOne();
		if (!($user instanceof \Higgs\Model\User))
			$this->abort(403);
		
		$factory = $app['security.encoder_factory'];
		$encoder = $factory->getEncoder($user);
		$password = $encoder->encodePassword($request->get('password'), $user->getSalt());
		if ($user->getPassword() !== $password)
			$this->abort(403);
		
		$app['security']->getToken()->setUser($user);
		
		return $user->eraseCredentials();
		
	}
	
	public static function logoutAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_USER'))
			$app->abort(403);
		
		$user = $app['security']->getToken()->getUser();
		
		// TODO : logout
		
		return $user;
		
	}
	
}

?>