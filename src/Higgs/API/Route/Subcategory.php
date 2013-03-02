<?php

namespace Higgs\API\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Subcategory extends \Higgs\API\Controller\APIController {
	
	public function createAction (Request $request, Application $app) {

		$subcategory = new \Higgs\Model\Subcategory;
		$subcategory->setTitle($request->get('title'));
		$subcategory->setCategoryId($request->get('categoryId'));
		if (!$subcategory) $app->abort(400);
		$subcategory->save();

		return $app->json($subcategory->toJSON());
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		$subcategory = \Higgs\Model\CategoryQuery::create()->findPK($request->get('id'));
		if (!$subcategory->validate()) $app->abort(400);
		return $subcategory;
		
	}
	
	public function listAction (Request $request, Application $app) {
		
		$subcategories = \Higgs\Model\CategoryQuery::create()->find();
		if (!$subcategories->validate()) $app->abort(400);
		return $subcategories;
		
	}
	
	public function deleteAction (Request $request, Application $app) {
		
		$subcategory = \Higgs\Model\CategoryQuery::create()->findPK($request->get('id'));
		if (!$subcategory->validate()) $app->abort(400);
		$subcategory->delete();
		return $subcategory;
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		$subcategory = \Higgs\Model\CategoryQuery::create()->findPK($request->get('id'));
		if (!$subcategory->validate()) $app->abort(400);
		$subcategory->setTitle($request->get('title'));
		if (!$subcategory->validate()) $app->abort(400);
		$subcategory->save();
		return $subcategory;
		
	}
	
}

?>