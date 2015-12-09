app.controller("TrainerController", function ($scope, $location, $route, API) {

    $scope.trainer = [];
    $scope.rival = null;
    $scope.pokedex = [];
    $scope.badges = [];
    var name = $route.current.params.name;
    $scope.addingPokemon = false;
    $scope.addingBadge = false;

    $scope.openBadges = function () {
        $location.path("/badges");
    }

    $scope.openPokemon = function (id) {
        $location.path('/pokedex/' + id);
    }

    $scope.openRival = function () {
        $location.path("/trainer/" + $scope.rival['name']);
    }

    var loadData = function () {
        API.getAllTrainers()
            .then(function successCallback(response) {
                var trainers = response.data;
                var id = findTrainerId(trainers);
                loadTrainer(id);
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    }

    var findTrainerId = function (trainerArray) {
        for (var i = 0; i < trainerArray.length; i++) {
            var thisTrainer = trainerArray[i];
            if (thisTrainer['name'] == name) {
                return thisTrainer['id'];
            }
        }
        return -1;
    };


    var loadTrainer = function (id) {
        API.getTrainerById(id)
            .then(function successCallback(response) {
                $scope.trainer = response.data;
                $scope.trainer['earned_badges'] = API.setBadgeImages(response.data['earned_badges']);
                $scope.trainer = API.setTrainerImage($scope.trainer);
                if ($scope.trainer['rival_id'] != null) {
                    loadRival();
                }
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    };



    var loadRival = function () {
        var rivalId = $scope.trainer['rival_id'];
        API.getTrainerById(rivalId)
            .then(function successCallback(response) {
                $scope.rival = response.data;
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    };

    $scope.addPokemonMode = function () {
        if ($scope.addingPokemon == true) {
            $scope.addingPokemon = false;
        } else {
            $scope.addingPokemon = true;
            API.getAllPokemon()
                .then(function successCallback(response) {
                    $scope.pokedex = response.data;
                }, function errorCallback(response) {
                    API.errorResponse(response);
                });
        }
    }

    $scope.addBadgeMode = function () {
        if ($scope.addingBadge == true) {
            $scope.addingBadge = false;
        } else {
            $scope.addingBadge = true;
            API.getAllBadges()
                .then(function successCallback(response) {
                    var badgeData = response.data;
                    $scope.badges = API.setBadgeImages(badgeData);
                    removeAlreadyOwnedBadges();
                }, function errorCallback(response) {
                    API.errorResponse(response);
                });
        }
    }

    var removeAlreadyOwnedBadges = function () {
        var ownedBadges = $scope.trainer.earned_badges.slice(0);
        for (var i = 0; i < ownedBadges.length; i++) {
            ownedBadges[i] = ownedBadges[i].id;
        }
        var badges = $scope.badges.slice(0);
        for (var i = 0; i < badges.length; i++) {
            badges[i] = badges[i].id;
        }

        for (var i = 0; i < ownedBadges.length; i++) {
            var index = badges.indexOf(ownedBadges[i]);
            if (index != -1) {
                badges.splice(index, 1);
                $scope.badges.splice(index, 1);
            }
        }
    }

    $scope.delete = function () {
        API.deleteTrainerById($scope.trainer.id)
            .then(function successCallback(response) {
                $location.path('/trainers');
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    }

    $scope.removeBadge = function (badgeId) {
        API.deleteBadgeFromTrainer($scope.trainer.id, badgeId)
            .then(function successCallback(response) {
                loadData();
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    }

    $scope.removePokemon = function (pokemonId) {
        API.deletePokemonFromTrainer($scope.trainer.id, pokemonId)
            .then(function successCallback(response) {
                loadData();
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
    }

    $scope.addPokemon = function (selectedPokemon) {
        if (selectedPokemon.level == null
            || !angular.isObject(selectedPokemon.level
            || selectedPokemon.level > 100
            || selectedPokemon.level < 5)){
            selectedPokemon.level = 5;
        };
        API.addSinglePokemonToTrainer($scope.trainer.id, selectedPokemon)
            .then(function successCallback(response) {
                loadData();
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
        $scope.addPokemonMode();
    }

    $scope.addBadge = function (newBadge) {
        API.addSingleBadgeToTrainer($scope.trainer.id, newBadge.id)
            .then(function successCallback(response) {
                loadData();
            }, function errorCallback(response) {
                API.errorResponse(response);
            });
        $scope.addBadgeMode();
    }

    loadData();
});