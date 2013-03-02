<?php

namespace Higgs\API\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Subject extends \Higgs\API\Controller\APIController {
	
	public function createAction (Request $request, Application $app) {

		$subject = new \Higgs\Model\Subject;
		$subject->setTitle($app->get('title'));
		$subject->setSubcategoryId($app->get('subcategoryId'));
		$subject->setUserId($app->get('userId'));
		if ($subject->validate()) $app->abort(400);
		$subject->save();

		return $app->json($subject->toJSON());
		
	}
	
	public function getAction (Request $request, Application $app) {
		
		$subject = \Higgs\Model\SubjectQuery::create()->findPK($request->get('id'));
		if (!$subject->validate()) $app->abort(400);
		return $app->json($subject->toJSON());
		
	}
	
	public function listAction (Request $request, Application $app) {
		
		$subjects = \Higgs\Model\SubjectQuery::create()->find();
		if (!$subjects->validate()) $app->abort(400);
		return $app->json($subjects->toJSON());
		
	}
	
	public function deleteAction (Request $request, Application $app) {
		
		$subject = \Higgs\Model\SubjectQuery::create()->findPK($request->get('id'));
		if (!$subject->validate()) $app->abort(400);
		$subject->delete();
		return $app->json($subject->toJSON());
		
	}
	
	public function updateAction (Request $request, Application $app) {
		
		$subject = \Higgs\Model\SubjectQuery::create()->findPK($request->get('id'));
		if (!$subject->validate()) $app->abort(400);
		$subject->setTitle($app->get('title'));
		if (!$subject->validate()) $app->abort(400);
		$subject->save();
		return $app->json($subject->toJSON());
		
	}
	
}

?>