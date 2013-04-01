'use strict';

(function(){
	
	function CategoryBackend (){};
	
	CategoryBackend.prototype = BackendFactory({
		list: function () {
			return $.get('/api/Category/list');
		},
		create: function (name) {
			return $.get('/api/Category/create', {name: name});
		},
	});
	
	window.CategoryBackend = CategoryBackend;	
	
})();