<?php

namespace Higgs\API\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class User extends \Higgs\API\BaseController {
	
	public function createAction (Request $request, Application $app, $password, $username, $email) {
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);

		$user = new \Higgs\Model\User;
		
		$factory = $app['security.encoder_factory'];
		$encoder = $factory->getEncoder($user);
		$password = $encoder->encodePassword($password, $user->getSalt());
		$user->setPassword($password);
		$user->setUsername($username);
		$user->setEmail($email);
		if (!$user->validate()) $app->abort(400);
		$user->save();

		return $user;
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$user = \Higgs\Model\UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort (400);
		return $user;
		
		
		
	}
	
	public function listAction (Request $request, Application $app) {
		
		var_dump($app['security']->getToken()->getUser());
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$users = \Higgs\Model\UserQuery::create()->find();
		if (!$users->validate()) $app->abort (400);
		return $users;
		
	}
	
	public function deleteAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$user = \Higgs\Model\UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort (400);
		$user->delete();
		return $user;
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		$user = \Higgs\Model\UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort(400);
		$user->setPassword(sha1($request->get('password')));
		$user->setUsername($request->get('username'));
		$user->setEmail($request->get('email'));
		if (!$user->validate()) $app->abort(400);
		$user->save();
		return $user;
		
	}
	
	public function loginAction (Request $request, Application $app, $email, $password) {
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);
		
		$user = \Higgs\Model\UserQuery::create()
				->filterByEmail($email)
				->findOne();
		if (!($user instanceof \Higgs\Model\User))
			$app->abort(403);
		
		$factory = $app['security.encoder_factory'];
		$encoder = $factory->getEncoder($user);
		$password = $encoder->encodePassword($password, $user->getSalt());
		if ($user->getPassword() !== $password)
			$app->abort(403);
		
		var_dump($app['security']->getToken(),$app['security']->getToken()->getUser());
		$app['security']->getToken()->setUser($user);
		var_dump($app['security']->getToken(),$app['security']->getToken()->getUser());
		
		return $user->eraseCredentials();
		
	}
	
	public function loggedAction (Request $request, Application $app, $email, $password) {
		
		return 'connected';
		
	}
	
	public function logoutAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_USER'))
			$app->abort(403);
		
		$user = $app['security']->getToken()->getUser();
		
		// TODO : logout
		
		return $user;
		
	}
	
}

?>