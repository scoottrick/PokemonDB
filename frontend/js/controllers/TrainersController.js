function TrainersController($http, $scope, $location) {
    $scope.trainers = [];
    $scope.createMode = false;
    $scope.badges = [];
    $scope.pokedex = [];
    $scope.selectedBadges = [];
    $scope.selectedPokemon = [];
    $scope.addPokemonSize = [0];

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


    $scope.viewTrainer = function (name) {
        $location.path("/trainer/" + name);
    };

    $scope.createTrainerMode = function () {
        if ($scope.createMode == true) {
            $scope.createMode = false;
        } else {
            $scope.createMode = true;
            loadBadges();
            loadPokemon();
        }
    };

    $scope.selectBadge = function (id) {
        var index = $scope.selectedBadges.indexOf(id);
        if (index != -1) {
            $scope.selectedBadges.splice(index, 1);
        } else {
            $scope.selectedBadges.push(id);
        }
    };

    $scope.badgeIsSelected = function (id) {
        var index = $scope.selectedBadges.indexOf(id);
        if (index != -1) {
            return true
        } else {
            return false;
        }
    }

    $scope.selectPokemon = function (index, id) {

        $scope.selectedPokemon[index] = id;
        //need to prevent from reselecting same pokemon with same level
    }

    $scope.pokemonIsSelected = function (id) {
        var index = $scope.selectedPokemon.indexOf(id);
        if (index != -1) {
            return true
        } else {
            return false;
        }
    }

    $scope.addMorePokemon = function () {
        var last = $scope.addPokemonSize[$scope.addPokemonSize.length - 1];
        last+=1;
        $scope.addPokemonSize.push(last);
    }

    $scope.submitNewTrainer = function () {
        console.log($scope.createTrainer);

        //        $http({
        //            method: 'POST',
        //            url: 'http://localhost:8888/PokemonDB/backend/trainers/create',
        //            headers: {
        //                'Content-Type': 'application/json'
        //            },
        //            transformRequest: function (obj) {
        //                var str = [];
        //                for (var p in obj)
        //                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        //                return str.join("&");
        //            },
        //            data: {
        //                name: trainer
        //            }
        //        }).success(function (response) {
        //            console.log("Success");
        //            console.log(response);
        //        });

        $scope.createTrainer();
    };







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

    var loadBadges = function () {
        $http({
            method: 'GET',
            //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/badges'
            url: 'http://localhost:8888/PokemonDB/backend/badges'
        }).then(function successCallback(response) {
            var badgeData = response.data;
            setBadgeImage(badgeData);
            shortenBadgeName();
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });


    };

    var loadPokemon = function () {
        $http({
            method: 'GET',
            //        url: 'http://bgroff-pi2.dhcp.bsu.edu/PokemonDB/backend/pokemon'
            url: 'http://localhost:8888/PokemonDB/backend/pokemon'
        }).then(function successCallback(response) {
            $scope.pokedex = response.data;
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    };

    var setBadgeImage = function (badgeData) {
        var temp = badgeData;
        for (var i = 0; i < temp.length; i++) {
            var badge = temp[i];
            var name = badge['name'];
            var index = name.indexOf(" ");
            var image = name.substring(0, index);
            badge['image'] = image;
            temp[i] = badge;
        };
        $scope.badges = temp;
    };

    var shortenBadgeName = function () {
        var temp = $scope.badges;
        for (var i = 0; i < temp.length; i++) {
            var badge = temp[i];
            var name = badge['name'];
            var index = name.indexOf(" ");
            var newName = name.substring(0, index);
            badge['name'] = newName;
            temp[i] = badge;
        };
        $scope.badges = temp;
    };
};