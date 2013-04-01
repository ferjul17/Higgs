'use strict';

(function(){
	var cpt = 0;
	var loadingWheel;
	
	function show() { loadingWheel.css('display','table'); }
	function hide() { loadingWheel.hide(); }
	function setElement () { loadingWheel = $('#loading-wheel').parents('.modal'); }
	
	function showLoadingWheel () {
		if (!cpt++) show();
	}	
	function hideLoadingWheel () {
		if (!--cpt) hide();
	}
	
	$(function(){
		setElement();
		if (cpt) show();
	});
	
	setElement();
	
	window.showLoadingWheel = showLoadingWheel;
	window.hideLoadingWheel = hideLoadingWheel;
})();