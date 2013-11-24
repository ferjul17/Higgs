<?php

namespace Higgs\API\Route;

use Higgs\API\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Silex\Application;
use Higgs\Provider\AuthentificateUser;
use Higgs\Model\User as UserModel;
use Higgs\Model\UserQuery;

class User extends BaseController {
	
	public function createAction (Request $request, Application $app, $password, $username, $email) {

        error_log("JE SUIS DEDANS");
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);
		
		if (UserQuery::create()->filterByEmail($email)->count()>0) {
			$app->abort(400, 'Email already used');
		}
		
		if (UserQuery::create()->filterByUsername($username)->count()>0) {
			$app->abort(400, 'Username already used');
		}

		$user = new UserModel;
		
		$factory = $app['security.encoder_factory'];
		$encoder = $factory->getEncoder(new AuthentificateUser($username, $password, $user->getSalt()));
		$password = $encoder->encodePassword($password, $user->getSalt());
		$user->setPassword($password);
		$user->setUsername($username);
		$user->setEmail($email);
		//if (!$user->validate()) $app->abort(400); TODO
		$user->save();

		return $user;
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$user = UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort (400);
		return $user;
		
		
		
	}
	
	public function listAction (Request $request, Application $app) {
		
		var_dump($app['security']->getToken()->getUser());
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$users = UserQuery::create()->find();
		if (!$users->validate()) $app->abort (400);
		return $users;
		
	}
	
	public function deleteAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$user = UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort (400);
		$user->delete();
		return $user;
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		$user = UserQuery::create()->findPK($request->get('id'));
		if (!$user->validate()) $app->abort(400);
		$user->setPassword(sha1($request->get('password')));
		$user->setUsername($request->get('username'));
		$user->setEmail($request->get('email'));
		if (!$user->validate()) $app->abort(400);
		$user->save();
		return $user;
		
	}
	
	// Implemented by the SecurityProvider
	//public function loginAction (Request $request, Application $app, $email, $password)
	
	public function logoutAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_USER'))
			$app->abort(403);
		
		$user = $app['security']->getToken()->getUser();
		
		// TODO : logout
		
		return $user;
		
	}
	
}

?>