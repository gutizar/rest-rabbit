'use strict';

/* Services */

angular.module('bookerServices', ['ngResource']).factory('Book', function($resource){
	return $resource('//api.angular.local/app_dev.php/bookapi/:bookId', {}, {
		query: {method: 'GET', params:{bookId:'books'}, isArray:true}
	});
});