<?php

namespace Higgs\API\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Post extends \Higgs\API\Controller\APIController {
	
	public function createAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_USER'))
			$app->abort(403);

		$post = new \Higgs\Model\Post;
		$post->setMessage($request->get('message'));
		$post->setSubjectId($request->get('subjectId'));
		$post->setUserId($request->get('userId'));
		if (!$post) $app->abort(400);
		$post->save();

		return $app->json($post->toJSON());
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);
		
		$post = \Higgs\Model\PostQuery::create()->findPK($request->get('id'));
		if (!$post->validate()) $app->abort (400);
		return $post;
		
		
		
	}
	
	public function listAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'))
			$app->abort(403);
		
		$posts = \Higgs\Model\PostQuery::create()->find();
		if (!$posts->validate()) $app->abort (400);
		return $posts;
		
	}
	
	public function deleteAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_USER'))
			$app->abort(403);
		
		$post = \Higgs\Model\PostQuery::create()->findPK($request->get('id'));
		if (!$post->validate()) $app->abort (400);
		$post->delete();
		return $post;
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_USER'))
			$app->abort(403);
		
		$post = \Higgs\Model\PostQuery::create()->findPK($request->get('id'));
		if (!$post->validate()) $app->abort(400);
		$post->setMessage($request->get('message'));
		$post->setEditorId($request->get('userId'));
		if (!$post->validate()) $app->abort(400);
		$post->save();
		return $post;
		
	}
	
}

?>