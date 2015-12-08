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

    $http({
        method: 'GET',
        url: $rootScope.baseURL + '/gyms'
    }).then(function successCallback(response) {
        var gyms = response.data;
        var id = findTrainerId(gyms);
        loadTrainerDataForId(id);
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
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
        $http({
            method: 'GET',
            url: $rootScope.baseURL + '/gyms/' + id
        }).then(function successCallback(response) {
            $scope.gym = response.data;
            setBadgeImage();
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }

    var setBadgeImage = function () {
        var badge = $scope.gym['badge'];
        var name = badge['name'];
        var index = name.indexOf(" ");
        var image = name.substring(0, index);
        badge['image'] = image;
        $scope.gym['badge'] = badge;
    };

});