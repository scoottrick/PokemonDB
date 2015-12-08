app.controller("TrainersController", function ($scope, $location, API) {
    $scope.trainers = [];
    $scope.createMode = false;
    $scope.badges = [];
    $scope.pokedex = [];
    $scope.selectedBadges = [];
    $scope.selectedPokemon = [];
    $scope.addPokemonSize = [0];
    $scope.sortOptions = {
        ID: "id",
        Name: "name",
        Badges: "-earned_badges.length"
    };
    $scope.reverse = false;
    $scope.sortValue = $scope.sortOptions.ID;

    $scope.sortBy = function(value){
        if ($scope.sortValue == value){
            $scope.reverse = !$scope.reverse;
        }
        $scope.sortValue = value;
    };

    var loadData = function () {
        API.getAllTrainers()
            .then(function successCallback(response) {
                $scope.trainers = API.setTrainerImages(response.data);
            }, function errorCallback(response) {
                API.errorResponse(response);
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

        API.createNewTrainer(data)
            .then(function successCallback(response) {
                loadData();
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
        $scope.createTrainerMode();
    };

    var loadBadges = function () {
        API.getAllBadges()
            .then(function successCallback(response) {
                $scope.badges = API.setBadgeImages(response.data);
                shortenBadgeName();
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    };

    var loadPokemon = function () {
        API.getAllPokemon()
            .then(function successCallback(response) {
                $scope.pokedex = response.data;
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
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

    //loads data for the first time when view is presented
    loadData();
});