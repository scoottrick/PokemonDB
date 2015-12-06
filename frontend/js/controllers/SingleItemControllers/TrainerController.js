function TrainerController($http, $scope, $location, $route, $rootScope) {

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
        $http({
            method: 'GET',
            url: $rootScope.baseURL + '/trainers'
        }).then(function successCallback(response) {
            var trainers = response.data;
            var id = findTrainerId(trainers);
            loadTrainer(id);
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
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
    }


    var loadTrainer = function (id) {
        $http({
            method: 'GET',
            url: $rootScope.baseURL + '/trainers/' + id
        }).then(function successCallback(response) {
            $scope.trainer = response.data;
            $scope.trainer['earned_badges'] = setBadgeImages(response.data['earned_badges']);
            setTrainerImage();
            if ($scope.trainer['rival_id'] != null) {
                loadRival();
            }
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }

    var setBadgeImages = function (badgeData) {
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

    var loadRival = function () {
        var rivalId = $scope.trainer['rival_id'];
        $http({
            method: 'GET',
            url: $rootScope.baseURL + '/trainers/' + rivalId
        }).then(function successCallback(response) {
            $scope.rival = response.data;
        }, function errorCallback(response) {
            alert("Database unreachable. Check console for more info.");
            console.log(response);
        });
    }

    $scope.addPokemonMode = function () {
        if ($scope.addingPokemon == true) {
            $scope.addingPokemon = false;
        } else {
            $scope.addingPokemon = true;
            $http({
                method: 'GET',
                url: $rootScope.baseURL + '/pokemon'
            }).then(function successCallback(response) {
                $scope.pokedex = response.data;
            }, function errorCallback(response) {
                alert("Database unreachable. Check console for more info.");
                console.log(response);
            });
        }
    }

    $scope.addBadgeMode = function () {
        if ($scope.addingBadge == true) {
            $scope.addingBadge = false;
        } else {
            $scope.addingBadge = true;
            $http({
                method: 'GET',
                url: $rootScope.baseURL + '/badges'
            }).then(function successCallback(response) {
                var badgeData = response.data;
                $scope.badges = setBadgeImages(badgeData);
                removeAlreadyOwnedBadges();
            }, function errorCallback(response) {
                alert("Database unreachable. Check console for more info.");
                console.log(response);
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
        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/delete',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                id: $scope.trainer.id
            }
        }).then(function callback(response) {
            $location.path('/trainers');
        });
    }

    $scope.removeBadge = function (badgeId) {
        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/' + $scope.trainer.id + '/badges/remove',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                badgeId: badgeId
            }
        }).then(function callback(response) {
            loadData();
        });
    }

    $scope.removePokemon = function (pokemonId) {
        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/' + $scope.trainer.id + '/pokemon/remove',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                pokemonId: pokemonId
            }
        }).then(function callback(response) {
            loadData();
        });
    }

    $scope.addPokemon = function (selectedPokemon) {
        console.log(selectedPokemon);
        var pokemonId = selectedPokemon.id;
        var pokemonLevel = selectedPokemon.level;

        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/' + $scope.trainer.id + '/pokemon/add',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                pokemonId: pokemonId,
                pokemonLevel: pokemonLevel
            }
        }).then(function callback(response) {
            loadData();
        });
        $scope.addPokemonMode();
    }

    $scope.addBadge = function (newBadge) {
        console.log(newBadge);
        var badgeId = newBadge.id;

        $http({
            method: 'POST',
            url: $rootScope.baseURL + '/trainers/' + $scope.trainer.id + '/badges/add',
            headers: {
                'Content-Type': 'application/json'
            },
            data: {
                badgeId: badgeId,
            }
        }).then(function callback(response) {
            loadData();
        });
        $scope.addBadgeMode();
    }

    loadData();
};