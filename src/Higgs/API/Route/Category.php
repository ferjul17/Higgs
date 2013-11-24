<?php

namespace Higgs\API\Route;

use Higgs\API\BaseController;
use Higgs\Model\Category as CategoryModel;
use Higgs\Model\CategoryQuery;
use Higgs\Model\Forum;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Category extends BaseController {
	
	public function createAction (Request $request, Application $app) {
		
		/*if (!$app['security']->isGranted('ROLE_CATEGORY_MANAGER'))
			$app->abort(403);*/

		$category = new CategoryModel;
		$category->setTitle($request->get('title'));
		if (!$category) $app->abort(400);
		$category->save();
		$category->toArray();

		return $app->json($category->toJSON());
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		$category = CategoryQuery::create()->findPK($request->get('id'));
		if (!$category->validate()) $app->abort(400);
		return $category;
		
	}
	
	public function listAction (Request $request, Application $app) {
		$f = new Forum();
		$categories = CategoryQuery::create()
				->setFormatter(ModelCriteria::FORMAT_ARRAY)
                ->leftJoin('Category.Forum')
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
		
		$category = CategoryQuery::create()->findPK($request->get('id'));
		if (!$category->validate()) $app->abort(400);
		$category->delete();
		return $category;
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		if (!$app['security']->isGranted('ROLE_CATEGORY_MANAGER'))
			$app->abort(403);
		
		$category = CategoryQuery::create()->findPK($request->get('id'));
		if (!$category->validate()) $app->abort(400);
		$category->setTitle($request->get('title'));
		if (!$category->validate()) $app->abort(400);
		$category->save();
		return $category;
		
	}
	
}

?>