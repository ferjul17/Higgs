'use strict';

(function(){
	
	var backend = {
		user: new UserBackend,
		category: new CategoryBackend,
	};
	
	function UserController ($scope) {
		$scope.create = function(username, email, password) {
			userBakend.create(username, email, password);
		}
		backend.user.list().success(function(data){
			$scope.categories = data;
		});
	}

	window.UserController = UserController;

})();