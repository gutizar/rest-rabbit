'use strict';

/* Controllers */

function SampleCtrl($scope, $http) {
	$http.get('//angular.local:8080/emc-rest/repositories/razvoj1/documents/090010e18000552e.json').success(function(data) {
		$scope.documentData = data;
		$scope.apiCallStatus = true;
	});

	$scope.apiCallStatus = false;
}

//SampleCtrl.$inject = ['$scope', '$http'];

function BookListCtrl($scope, $http) {
	$http.get('//api.angular.local/app_dev.php/bookapi').success(function(data) {
		$scope.appData = data;
		$scope.apiCallStatus = true;
	});

	$scope.apiCallStatus = false;
	$scope.orderProp = 'publish_date';
}

//BookListCtrl.$inject = ['$scope', '$http'];


function BookDetailCtrl($scope, $routeParams, $http) {
	$http.get('//api.angular.local/app_dev.php/bookapi/' + $routeParams.bookId).success(function(data) {
		$scope.appData = data;
		$scope.apiCallStatus = true;
	});

	$scope.apiCallStatus = false;
}

//BookDetailCtrl.$inject = ['$scope', '$routeParams', '$http'];


function ErrorCtrl($scope, $routeParams) {
  $scope.message = 'Sorry, I could not find what you were looking for.'
}

//ErrorCtrl.$inject = ['$scope', '$routeParams'];

function FootCtrl($scope)
{
	$scope.hello = 'TESTING';
}