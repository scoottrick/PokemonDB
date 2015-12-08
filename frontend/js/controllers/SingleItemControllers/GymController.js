app.controller("GymController", function ($scope, $location, $route, API) {
    $scope.gym = [];
    $scope.name = $route.current.params.name;
    $scope.name = $scope.name.replace("_", " ");

    $scope.openBadges = function () {
        $location.path("/badges");
    }

    $scope.openLeader = function () {
        var name = $scope.gym['leader']['name'];
        $location.path("/trainer/" + name);
    }

    API.getAllGyms()
        .then(function successCallback(response) {
        var gyms = response.data;
        var id = findTrainerId(gyms);
        loadTrainerDataForId(id);
    }, function errorCallback(response) {
        API.errorResponse(response);
    });

    var findTrainerId = function (gymArray) {
        for (var i = 0; i < gymArray.length; i++) {
            var gym = gymArray[i];
            if (gym['name'] == $scope.name) {
                return gym['id'];
            }
        }
        return -1;
    }

    var loadTrainerDataForId = function (id) {
        API.getGymById(id)
            .then(function successCallback(response) {
            $scope.gym = response.data;
            $scope.gym['badge'] = API.setBadgeImage($scope.gym['badge']);
        }, function errorCallback(response) {
            API.errorResponse(response);
        });
    }
});