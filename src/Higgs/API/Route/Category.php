<?php

namespace Higgs\API\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Category extends \Higgs\API\BaseController {
	
	public function createAction (Request $request, Application $app) {
		
		/*if (!$app['security']->isGranted('ROLE_CATEGORY_MANAGER'))
			$app->abort(403);*/

		$category = new \Higgs\Model\Category;
		$category->setTitle($request->get('title'));
		if (!$category) $app->abort(400);
		$category->save();
		$category->toArray();

		return $app->json($category->toJSON());
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		$category = \Higgs\Model\CategoryQuery::create()->findPK($request->get('id'));
		if (!$category->validate()) $app->abort(400);
		return $category;
		
	}
	
	public function listAction (Request $request, Application $app) {
		$f = new \Higgs\Model\Forum();
		$categories = \Higgs\Model\CategoryQuery::create()
				->setFormatter('PropelArrayFormatter')
				->leftJoinForum()
				->leftJoin('Forum.Subject')
				->leftJoin('Forum.LastPost')
				->with('Forum')
				->with('LastPost')
				->orderBy('id')
				->orderBy('Subject.created_at','DESC')
				->find();
		return $categories;
		
	}
	
	public function deleteAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_ADMIN'))
			$app->abort(403);
		
		$category = \Higgs\Model\CategoryQuery::create()->findPK($request->get('id'));
		if (!$category->validate()) $app->abort(400);
		$category->delete();
		return $category;
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_CATEGORY_MANAGER'))
			$app->abort(403);
		
		$category = \Higgs\Model\CategoryQuery::create()->findPK($request->get('id'));
		if (!$category->validate()) $app->abort(400);
		$category->setTitle($request->get('title'));
		if (!$category->validate()) $app->abort(400);
		$category->save();
		return $category;
		
	}
	
}

?>