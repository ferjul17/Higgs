'use strict';

(function(){
	
	function BackendFactory (proto) {
		$.each(proto, function(key, fn){
			proto[key] = function() {
				showLoadingWheel();
				return fn.apply(this,arguments).always(hideLoadingWheel);
			};
		});
		return proto;
	}
	
	window.BackendFactory = BackendFactory;
	
})();