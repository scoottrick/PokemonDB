app.controller("TrainersController", function ($scope, $location, API) {
    $scope.trainers = [];
    $scope.createMode = false;
    $scope.badges = [];
    $scope.pokedex = [];
    $scope.selectedBadges = [];
    $scope.selectedPokemon = [];
    $scope.addPokemonSize = [0];


    var loadData = function () {
        $http({
            method: 'GET',
            url: $rootScope.baseURL + '/trainers'
        }).then(function successCallback(response) {
            $scope.trainers = response.data;
            setImage();
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }

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
        if ($scope.selectedPokemon[index] == null) {
            $scope.selectedPokemon[index] = {
                pokemonId: id,
                pokemonLevel: 5
            };
        } else {
            var temp = $scope.selectedPokemon[index];
            temp = {
                pokemonId: id,
                pokemonLevel: temp['pokemonLevel']
            };
            $scope.selectedPokemon[index] = temp;
        }

        //need to prevent from reselecting same pokemon with same level
    }

    $scope.updatePokemonLevel = function (index, level) {
        var temp = $scope.selectedPokemon[index];
        temp = {
            pokemonId: temp['pokemonId'],
            pokemonLevel: level
        };
        $scope.selectedPokemon[index] = temp;
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
        last += 1;
        $scope.addPokemonSize.push(last);
    }

    $scope.submitNewTrainer = function () {
        if (!angular.isObject($scope.newTrainer)) {
            $scope.createTrainerMode();
            return;
        }
        var rivalID = null;
        if (angular.isObject($scope.newTrainer.rival)) {
            rivalID = $scope.newTrainer.rival.id;
        }

        var data = {
            name: $scope.newTrainer.name,
            rivalId: rivalID,
            pokemon: $scope.selectedPokemon,
            badgeIds: $scope.selectedBadges
        };

        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/create',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                name: data.name,
                rivalId: data.rivalId,
                pokemon: data.pokemon,
                badgeIds: data.badgeIds
            }
        }).then(function callback(response) {
            console.log(response);
            loadData();
        });
        $scope.createTrainerMode();

    };

    $scope.delete = function (trainerId) {
        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/delete',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: trainerId
            }
        }).then(function callback(response) {
            if (response.data == true) {
                loadData();
            } else {
                console.log(response);
            }
        });

    }

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
            url: $rootScope.baseURL + '/badges'
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
            url: $rootScope.baseURL + '/pokemon'
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

    loadData();
});