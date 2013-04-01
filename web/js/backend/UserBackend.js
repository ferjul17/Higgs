'use strict';

(function(){
	
	function UserBackend (){};
	
	UserBackend.prototype = BackendFactory({
		login: function (email, password) {
			return $.get('/api/User/login', {email: email, password: password});
		},
		create: function (username, email, password) {
			return $.get('/api/User/create', {username: username, email: email, password: password});
		},
	});
	
	window.UserBackend = UserBackend;	
	
})();