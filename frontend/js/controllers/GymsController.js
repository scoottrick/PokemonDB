app.controller("GymsController", function ($http, $scope, $location, API) {
    $scope.gyms = [];

    $scope.openGym = function (name) {
        name = name.replace(" ", "_");
        $location.path('/gym/' + name);
    };

    API.getAllGyms()
        .then(function successCallback(response) {
        $scope.gyms = response.data;
    }, function errorCallback(response) {
        API.errorResponse(response);
    });

});