function TrainersController($http, $scope, $location) {
    $scope.trainers = [];
    $scope.createMode = false;

    $scope.viewTrainer = function (id) {
        $location.path("/trainer/" + id);
    };

    $scope.createTrainer = function () {
        if ($scope.createMode == true) {
            $scope.createMode = false;
        } else {
            $scope.createMode = true;
        }
    };

    $scope.submitNewTrainer = function (trainer) {
        console.log(trainer);

        $http({
            method: 'POST',
            url: 'http://localhost:8888/PokemonDB/backend/trainers',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            transformRequest: function (obj) {
                var str = [];
                for (var p in obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                return str.join("&");
            },
            data: {
                name: trainer
            }
        }).success(function (response) {
            console.log("Success");
            console.log(response);
        });

        $scope.createTrainer();
    };

    $http({
        method: 'GET',
        //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/trainers'
        url: 'http://localhost:8888/PokemonDB/backend/trainers'
    }).then(function successCallback(response) {
        $scope.trainers = response.data;
        setImage();
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });


    var setImage = function () {
        for (var i = 0; i < $scope.trainers.length; i++) {
            var trainer = $scope.trainers[i];
            if (trainer['id'] <= 10) {
                trainer['image'] = trainer['name'];
            } else {
                trainer['image'] = "Avatar";
            }
            $scope.trainers[i] = trainer;
        }
    };
};