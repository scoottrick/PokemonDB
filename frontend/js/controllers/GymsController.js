function GymsController($http, $scope, $location, $rootScope) {
    $scope.gyms = [];

    $scope.openGym = function(name){
        name = name.replace(" ", "_");
        $location.path('/gym/' + name);
    };

    $http({
        method: 'GET',
        url: $rootScope.baseURL+'/gyms'
    }).then(function successCallback(response) {
        $scope.gyms = response.data;
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

};