'use strict';

/* Directives */
angular.module('mdpublisherDirectives', []).directive('markdown', function($compile, $http) {
    var converter = new Showdown.converter();
    // var hljs = new hljs();
    return {
    	transclude: true,
        restrict: 'E',
        replace: true,
        link: function(scope, element, attrs) {
        	attrs.$observe('contentPath', function(value) {
	            $http.get(value).success(function(data) {
				    var htmlContent = converter.makeHtml(data);
				    element.html(htmlContent);
				    $('pre code').each(function(i, e){
				   		hljs.highlightBlock(e);
				    })
				});
          });	
        }
    }
});