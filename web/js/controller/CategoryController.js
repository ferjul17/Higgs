'use strict';

(function(){
	
	var backend = {
		user: new UserBackend,
		category: new CategoryBackend,
	};
	
	function CategoryController ($scope) {
		/*
		$scope.categories = [{Title:'cat1',Subcategorys:[{Title:'subcat'},{Title:'sub2'},{Title:'sub3'}]},{Title:'cat2',Subcategorys:[{Title:'sub1'},{Title:'sub2'}]}]
		/*/
		backend.category.list().success(function(data){
			$scope.$apply(function(scope) {
				scope.categories = data;
			});
		});
		//*/
	}
	
	window.CategoryController = CategoryController;
	
})();
