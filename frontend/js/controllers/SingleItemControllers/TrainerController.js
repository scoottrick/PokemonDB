function TrainerController($http, $scope, $location, $route) {

    $scope.trainer = [];
    $scope.rival = null;
    var name = $route.current.params.name;

    $scope.openBadges = function() {
        $location.path("/badges");
    }

    $scope.openPokemon = function(id){
        $location.path('/pokedex/' + id);
    }

    $scope.openRival = function() {
        $location.path("/trainer/" + $scope.rival['name']);
    }

    $http({
        method: 'GET',
        //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/trainers/'
        url: 'http://localhost:8888/PokemonDB/backend/trainers'
    }).then(function successCallback(response) {
        var trainers = response.data;
        var id = findTrainerId(trainers);
        loadTrainer(id);
    }, function errorCallback(response) {
        alert("Database unreachable. Check console for more info.");
        console.log(response);
    });

    var findTrainerId = function (trainerArray) {
        for (var i = 0; i < trainerArray.length; i++) {
            var thisTrainer = trainerArray[i];
            if (thisTrainer['name'] == name) {
                return thisTrainer['id'];
            }
        }
        return -1;
    }


    var loadTrainer = function (id) {
        $http({
            method: 'GET',
            //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/trainers/' + id
            url: 'http://localhost:8888/PokemonDB/backend/trainers/' + id
        }).then(function successCallback(response) {
            $scope.trainer = response.data;
            $scope.trainer['earned_badges'] = setImages(response.data['earned_badges']);
            setTrainerImage();
            if ($scope.trainer['rival_id'] != null){
                loadRival();
            }
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }

    var setImages = function (badgeData) {
        var temp = badgeData;
        for (var i = 0; i < temp.length; i++) {
            var badge = temp[i];
            var name = badge['name'];
            var index = name.indexOf(" ");
            var image = name.substring(0, index);
            badge['image'] = image;
            temp[i] = badge;
        };
        return temp;
    };

    var setTrainerImage = function () {
        var trainer = $scope.trainer;
        if (trainer['id'] <= 10) {
            trainer['image'] = trainer['name'];
        } else {
            trainer['image'] = "Avatar";
        }
        $scope.trainer = trainer;
    };

    var loadRival = function() {
        var rivalId = $scope.trainer['rival_id'];
        $http({
            method: 'GET',
            //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/trainers/' + id
            url: 'http://localhost:8888/PokemonDB/backend/trainers/' + rivalId
        }).then(function successCallback(response) {
            $scope.rival = response.data;
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }
};