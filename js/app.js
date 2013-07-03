'use strict';

/* App Module */

angular.module('booker', ['mdpublisherFilters', 'mdpublisherDirectives']).
	config(['$routeProvider', function($routeProvider) {
		$routeProvider.
			when('/', {redirectTo: '/books'}).
			when('/sample', {templateUrl: 'partials/sample.html', controller: SampleCtrl}).
			when('/books', {templateUrl: 'partials/book-list.html',   controller: BookListCtrl}).
	  		when('/books/:bookId', {templateUrl: 'partials/book-detail.html', controller: BookDetailCtrl}).
	  		when('/404', {templateUrl: 'partials/404.html', controller : ErrorCtrl}).
	  	otherwise({redirectTo: '/404'});
	}]).
	config(['$httpProvider', function($httpProvider) {
		$httpProvider.defaults.headers.common.Authorization = 'Basic ' + btoa('dmadmin:razvoj');
		$httpProvider.defaults.headers.common['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS';
		$httpProvider.defaults.headers.common['Access-Control-Allow-Origin'] = 'http://angular.local';
		$httpProvider.defaults.headers.common['Access-Control-Allow-Credentials'] = true;
    	// delete $httpProvider.defaults.headers.common["X-Requested-With"];
	}]);